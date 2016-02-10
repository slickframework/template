<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template;

use Slick\Common\Base;
use ReflectionClass;

/**
 * Template factory class
 *
 * @package Slick\Template
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 *
 * @property array $extensions
 * @property string $engine
 */
final class Template extends Base
{

    /** Known engines */
    const ENGINE_TWIG = 'Slick\Template\Engine\Twig';

    /** Known engine extensions */
    const EXTENSION_TWIG_TEXT = 'Slick\Template\Extension\Text';
    const EXTENSION_TWIG_I18N = 'Slick\Template\Extension\I18n';

    /** @var string Engine interface */
    private static $interface = 'Slick\Template\TemplateEngineInterface';
    private static $extensionInterface =
        'Slick\Template\EngineExtensionInterface';

    /**
     * @readwrite
     * @var string The engine to use
     */
    protected $engine = self::ENGINE_TWIG;

    /**
     * @readwrite
     * @var array Options for template initializing
     */
    protected $options = array();

    /**
     * @var string[] a list of available paths
     */
    protected static $paths = ['./'];

    /**
     * @readwrite
     * @var array Array containing template extensions
     */
    protected $extensions = [
        self::EXTENSION_TWIG_TEXT => null,
        self::EXTENSION_TWIG_I18N => null,
    ];

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
     * Prepends a searchable path to available paths list.
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
     * Gets the list of defined paths
     *
     * @return \string[]
     */
    public static function getPaths()
    {
        return self::$paths;
    }

    /**
     * Initializes the engine
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return TemplateEngineInterface
     */
    public function initialize()
    {
        $this->checkClass();
        /** @var TemplateEngineInterface $engine */
        $engine = new $this->engine($this->options);
        $engine->setLocations(self::$paths);
        return $this->applyExtensions($engine);
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

        $this->checkClass($className, self::$extensionInterface);

        $this->extensions[$className] = $object;
        return $this;

    }

    /**
     * Apply defined extensions to the provided template engine
     *
     * @param TemplateEngineInterface $engine
     *
     * @return TemplateEngineInterface
     */
    protected function applyExtensions(TemplateEngineInterface $engine)
    {
        foreach ($this->extensions as $className => $extension) {
            $ext = $this->getExtension($className, $extension);
            if ($ext->appliesTo($engine)) {
                $ext->update($engine);
            }
        }
        return $engine;
    }

    /**
     * @param string $class
     * @param EngineExtensionInterface $extension
     *
     * @return EngineExtensionInterface
     */
    protected function getExtension($class, $extension)
    {
        if (is_object($extension)) {
            return $extension;
        }

        $this->checkClass($class, self::$extensionInterface);
        return new $class();
    }

    /**
     * Check if type is a valid configuration driver
     *
     * @param null $name
     * @param null $interface
     */
    protected function checkClass($name = null, $interface = null)
    {
        $name = null == $name ? $this->engine : $name;
        $interface = null == $interface ? self::$interface : $interface;

        if (!class_exists($name)) {
            throw new Exception\InvalidArgumentException(
                "The class '{$name}' was not found"
            );
        }

        $reflection = new ReflectionClass($name);
        if (!$reflection->implementsInterface($interface)) {
            throw new Exception\InvalidArgumentException(
                "Class '{$name}' does not implement {$interface}"
            );
        }
    }
}
