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
     * @var array Default options for template initializing
     */
    protected static $defaultOptions = [];

    /**
     * @var array Array containing template extensions
     */
    private static $extensions = [
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
        $options = array_merge(static::$defaultOptions, $this->options);
        /** @var TemplateEngineInterface $engine */
        $engine = new $this->engine($options);
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

        self::$extensions[$className] = $object;
        return $this;
    }

    /**
     * Registers the provided class name as an extension
     * 
     * @param string|object $extension The class name or an instance
     *                                 of EngineExtensionInterface interface
     *
     * @return Template
     */
    public static function register($extension)
    {
        $template = new Template;
        return $template->addExtension($extension);
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
        foreach (static::$extensions as $className => $extension) {
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

    /**
     * Get current configured extensions
     * 
     * @return array
     */
    public function getExtensions()
    {
        return self::$extensions;
    }

    /**
     * Set or reset the list of extensions
     * 
     * @param array $extensions
     * 
     * @return Template
     */
    public function setExtensions(array $extensions)
    {
        self::$extensions = $extensions;
        return $this;
    }

    /**
     * Set default options
     * 
     * If an array is given on $option parameter it should be assigned
     * to the static $defaultOptions property.
     * 
     * For other values only the key provided in $option parameter should
     * be overridden.
     * 
     * @param array|string|int $option
     * 
     * @param mixed $value
     */
    public static function setDefaultOptions($option, $value = null)
    {
        if (is_array($option) && null == $value) {
            static::$defaultOptions = $option;
        }
        
        if (is_scalar($option)) {
            static::$defaultOptions[$option] = $value;
        }
    }

    /**
     * Get current default options
     * 
     * @return array
     */
    public static function getDefaultOptions()
    {
        return static::$defaultOptions;
    }
}
