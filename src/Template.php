<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template;

use Slick\Template\Engine\Twig;
use Slick\Template\Exception\InvalidArgumentException;
use Slick\Template\Extension\Text;

/**
 * Template
 *
 * @package Slick\Template
 */
final class Template
{

    /** Known engines */
    const ENGINE_TWIG = Twig::class;

    /** Known engine extensions */
    const EXTENSION_TWIG_TEXT = Text::class;

    private array $defaultOptions = [];

    private array $options;

    private string $engine;

    /**
     * @var array<string> a list of available paths
     */
    private static array $paths = ['./'];

    /**
     * @var array<string, EngineExtensionInterface|null> Array containing template extensions
     */
    private static array $extensions = [
        self::EXTENSION_TWIG_TEXT => null,
    ];

    /**
     * Creates a template factory
     *
     * @param array|null $options
     */
    public function __construct(?array $options = [])
    {
        $this->engine = array_key_exists('engine', $options)
            ? $this->checkEngine($options['engine'])
            : self::ENGINE_TWIG;

        $this->options = array_key_exists('options', $options)
            ? array_merge($this->defaultOptions, $options['options'])
            : $this->defaultOptions;
    }

    /**
     * Prepends a searchable path to available paths list.
     *
     * @param string $path
     */
    public static function addPath(string $path): void
    {
        $path = str_replace('//', '/', rtrim($path, '/'));
        if (is_dir($path) && !in_array($path, self::$paths)) {
            array_unshift(self::$paths, $path);
        }
    }

    /**
     * Appends a searchable path to available paths list.
     *
     * @param string $path
     */
    public static function appendPath(string $path): void
    {
        $path = str_replace('//', '/', rtrim($path, '/'));
        if (is_dir($path) && !in_array($path, self::$paths)) {
            self::$paths[] = $path;
        }
    }

    /**
     * Adds an extension to the template engine
     *
     * @param object|string $className The class name or an instance
     *                                 of EngineExtensionInterface interface
     *
     * @return self
     */
    public function addExtension(object|string $className): self
    {
        $object = is_object($className) ? $className : null;
        $className = is_object($className) ? get_class($object) : $className;

        $this->checkExtension($className);

        self::$extensions[$className] = $object;
        return $this;
    }

    /**
     * Initializes the engine
     *
     * @return TemplateEngineInterface
     */
    public function initialize(): TemplateEngineInterface
    {
        /** @var TemplateEngineInterface $engine */
        $engine = new $this->engine($this->options);
        $engine->setLocations(self::$paths);
        $this->applyExtensions($engine);
        return $engine;
    }

    /**
     * Checks if provided class implements the TemplateEngineInterface
     *
     * @param string $engine
     *
     * @return string
     */
    private function checkEngine(string $engine): string
    {
        if (! is_subclass_of($engine, TemplateEngineInterface::class)) {
            $name = TemplateEngineInterface::class;
            throw new InvalidArgumentException(
                "Class '$engine' does not implement '$name'."
            );
        }
        return $engine;
    }

    /**
     * Apply defined extensions to the provided template engine
     *
     * @param TemplateEngineInterface $engine
     *
     * @return void
     */
    private function applyExtensions(TemplateEngineInterface $engine): void
    {
        foreach (Template::$extensions as $className => $extension) {
            $ext = $this->getExtension($className, $extension);
            if ($ext->appliesTo($engine)) {
                $ext->update($engine);
            }
        }
    }

    /**
     * Creates the extension
     *
     * @param string $class
     * @param EngineExtensionInterface|string|null $extension
     *
     * @return EngineExtensionInterface
     */
    private function getExtension(
        string $class,
        EngineExtensionInterface|string|null $extension
    ): EngineExtensionInterface {
        if (is_object($extension)) {
            return $extension;
        }
        $this->checkExtension($class);
        return new $class();
    }

    /**
     * Checks if provided class implements the EngineExtensionInterface
     *
     * @param string $class
     *
     * @return void
     */
    private function checkExtension(string $class): void
    {
        if (! is_subclass_of($class, EngineExtensionInterface::class)) {
            $name = TemplateEngineInterface::class;
            throw new InvalidArgumentException(
                "Engine extension '$class' does not implement '$name'."
            );
        }
    }
}
