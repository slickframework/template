<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Engine;

use Slick\Template\TemplateEngineInterface;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;
use Twig_TemplateWrapper;

/**
 * Twig
 *
 * @package Slick\Template\Engine
 */
class Twig implements TemplateEngineInterface
{

    /**
     * @var array
     */
    private $optionsMap = [
        'debug' => 'debug',
        'autoEscape' => 'autoescape',
        'strictVariables' => 'strict_variables',
        'autoReload' => 'auto_reload',
        'cache' => 'cache',
        'baseTemplateClass' => 'base_template_class',
        'charset' => 'charset',
        'optimizations' => 'optimizations'
    ];

    /**
     * @var array
     */
    private $defaultOptions = [
        'debug' => false,
        'autoEscape' => true,
        'strictVariables' => false,
        'autoReload' => false,
        'cache' => false,
        'baseTemplateClass' => 'Twig_Template',
        'charset' => 'utf8',
        'optimizations' => -1
    ];

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var Twig_Environment
     */
    private $twigEnvironment;

    /**
     * @var array
     */
    private $locations = [];

    /**
     * @var Twig_Loader_Filesystem
     */
    private $loader;

    /**
     * @var Twig_TemplateWrapper
     */
    private $template;

    /**
     * Creates a Twig template engine
     *
     * @param array $options
     * @param Twig_Environment $twigEnvironment
     */
    public function __construct(array $options = [], Twig_Environment $twigEnvironment = null)
    {
        $this->options = array_merge($this->defaultOptions, $options);
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
     * Engine configuration options
     *
     * @return array
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * Parses the source template code.
     *
     * @param string $source The template to parse
     *
     * @return TemplateEngineInterface|self|$this
     *
     * @throws \Twig_Error_Loader  When the template cannot be found
     * @throws \Twig_Error_Runtime When a previously generated cache is corrupted
     * @throws \Twig_Error_Syntax  When an error occurred during compilation
     */
    public function parse($source)
    {
        $this->template = $this->getTwigEnvironment()->load($source);
        return $this;
    }

    /**
     * Processes the template with data to produce the final output.
     *
     * @param mixed $data The data that will be used to process the view.
     *
     * @return string Returns processed output string.
     */
    public function process($data = array())
    {
        return $this->template->render($data);
    }

    /**
     * Sets the list of available locations for template files.
     *
     * @param array $locations
     *
     * @return TemplateEngineInterface|self|$this
     */
    public function setLocations(array $locations)
    {
        $this->locations = $locations;
        return $this;
    }

    /**
     * Returns the source template engine
     *
     * @return object
     */
    public function getSourceEngine()
    {
        return $this->getTwigEnvironment();
    }

    /**
     * Creates a twig environment if not injected
     *
     * @return Twig_Environment
     */
    private function getTwigEnvironment()
    {
        if (null == $this->twigEnvironment) {
            $this->twigEnvironment = $this->createTwigEnvironment();
        }
        return $this->twigEnvironment;
    }

    /**
     * Creates the twig environment
     *
     * @return Twig_Environment
     */
    private function createTwigEnvironment()
    {
        $twigEnv = new Twig_Environment(
            $this->getLoader(),
            $this->getOptions()
        );

        if ($this->options['debug']) {
            $twigEnv->addExtension(new Twig_Extension_Debug());
        }

        return $twigEnv;
    }

    /**
     * Creates a file system loader
     *
     * @return Twig_Loader_Filesystem
     */
    private function getLoader()
    {
        if (null == $this->loader) {
            $this->loader = new Twig_Loader_Filesystem(
                $this->locations
            );
        }
        return $this->loader;
    }

    /**
     * Returns current configured options
     *
     * @return array
     */
    private function getOptions()
    {
        $options = [];
        foreach($this->optionsMap as $property => $name) {
            $options[$name] = $this->options[$property];
        }
        return $options;
    }
}
