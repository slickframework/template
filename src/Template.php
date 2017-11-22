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
class Template
{

    /** Known engines */
    const ENGINE_TWIG = Twig::class;

    /** Known engine extensions */
    const EXTENSION_TWIG_TEXT = Text::class;

    /**
     * @var array
     */
    private $defaultOptions = [];

    /**
     * @var array
     */
    private $options;

    /**
     * @var string
     */
    private $engine;

    /**
     * @var string[] a list of available paths
     */
    private static $paths = ['./'];

    /**
     * @var array Array containing template extensions
     */
    private static $extensions = [
        self::EXTENSION_TWIG_TEXT => null,
    ];

    /**
     * Creates a template factory
     *
     * @param array $options
     */
    public function __construct(array $options = [])
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
    public static function addPath($path)
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
    public static function appendPath($path)
    {
        $path = str_replace('//', '/', rtrim($path, '/'));
        if (is_dir($path) && !in_array($path, self::$paths)) {
            array_push(self::$paths, $path);
        }
    }

    /**
     * Adds an extension to the template engine
     *
     * @param string|object $className The class name or an instance
     *                                 of EngineExtensionInterface interface
     *
     * @return self|$this|Template
     */
    public function addExtension($className)
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
    public function initialize()
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
    private function checkEngine($engine)
    {
        if (! is_subclass_of($engine, TemplateEngineInterface::class)) {
            $name = TemplateEngineInterface::class;
            throw new InvalidArgumentException(
                "Class '{$engine}' does not implement '{$name}'."
            );
        }
        return $engine;
    }

    /**
     * Apply defined extensions to the provided template engine
     *
     * @param TemplateEngineInterface $engine
     *
     * @return TemplateEngineInterface
     */
    private function applyExtensions(TemplateEngineInterface $engine)
    {
        foreach (static::$extensions as $className => $extension) {
            $ext = $this->getExtension($className, $extension);
            if ($ext->appliesTo($engine)) {
                $ext->update($engine);
            }
        }
        return $engine;
    }

    /**
     * Creates the extension
     *
     * @param string $class
     * @param EngineExtensionInterface $extension
     *
     * @return EngineExtensionInterface
     */
    private function getExtension($class, $extension)
    {
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
     * @return string
     */
    private function checkExtension($class)
    {
        if (! is_subclass_of($class, EngineExtensionInterface::class)) {
            $name = TemplateEngineInterface::class;
            throw new InvalidArgumentException(
                "Engine extension '{$class}' does not implement '{$name}'."
            );
        }
        return $class;
    }
}
