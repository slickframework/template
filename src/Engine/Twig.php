<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Engine;

use Slick\Template\Exception\ParserException;
use Slick\Template\TemplateEngineInterface;

/**
 * Twig
 *
 * @package Slick\Template\Engine
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 *
 * @property array  $locations A list of paths for template files.
 * @property string $cache   Absolute path for compiled templates.
 * @property bool   $debug   Set debug mode and display the generated nodes.
 * @property string $charset The charset used by the templates.
 * @property string $baseTemplateClass
 *      The base template class to use for generated templates.
 * @property bool   $autoReload
 *      Recompile the template whenever the source code changes.
 * @property bool   $strictVariables
 *      When false it silently ignore invalid variables (variables and or
 *      attributes/methods that do not exist) and replace them with a null
 *      value.
 * @property bool   $autoEscape    HTML auto-escaping
 * @property int    $optimizations
 *      A flag that indicates which optimizations to apply (default
 *      to -1 -- all optimizations are enabled; set it to 0 to disable).
 *
 * @property \Twig_Loader_Filesystem $loader
 * @property \Twig_Environment $twigEnvironment
 * @property-write \Twig_Template $template
 *
 */
class Twig extends AbstractEngine
{

    /**
     * @readwrite
     * @var \Twig_Loader_Filesystem
     */
    protected $loader;

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
     * @readwrite
     * @var \Twig_Environment
     */
    protected $twigEnvironment;

    /**
     * @write
     * @var \Twig_Template
     */
    protected $template;

    /**
     * @readwrite
     * @var string|false
     */
    protected $cache = false;

    /**
     * @readwrite
     * @var string
     */
    protected $charset = 'utf8';

    /**
     * @readwrite
     * @var string
     */
    protected $baseTemplateClass = 'Twig_Template';

    /**
     * @readwrite
     * @var bool
     */
    protected $autoReload = false;

    /**
     * @readwrite
     * @var bool
     */
    protected $strictVariables = false;

    /**
     * @readwrite
     * @var bool|string
     */
    protected $autoEscape = true;

    /**
     * @readwrite
     * @var int
     */
    protected $optimizations = -1;

    /**
     * @readwrite
     * @var bool
     */
    protected $debug = false;

    /**
     * @readwrite
     * @var array
     */
    protected $locations = [];

    /**
     * Parses the source template code.
     *
     * @param string $source The template to parse
     *
     * @return TemplateEngineInterface|self|$this
     *
     * @throws ParserException If any error occurs parsing the template
     */
    public function parse($source)
    {
        try {
            $this->template = $this->getTwigEnvironment()
                ->loadTemplate($source);
        } catch (\Exception $caught) {
            throw new ParserException(
                "Template parse error: ".$caught->getMessage(),
                0,
                $caught
            );
        }
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
        try {
            return $this->template->render($data);
        } catch (\Exception $caught) {
            throw new ParserException(
                "Template process error: ".$caught->getMessage(),
                0,
                $caught
            );
        }
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
     * @return \Twig_Environment
     */
    public function getSourceEngine()
    {
        return $this->getTwigEnvironment();
    }

    /**
     * Gets the twig environment object
     *
     * @return \Twig_Environment
     */
    protected function getTwigEnvironment()
    {
        if (null == $this->twigEnvironment) {
            $this->twigEnvironment = new \Twig_Environment(
                $this->getLoader(),
                $this->getOptions()
            );
        }
        return $this->twigEnvironment;
    }

    /**
     * Creates a file system loader
     *
     * @return \Twig_Loader_Filesystem
     */
    protected function getLoader()
    {
        if (null == $this->loader) {
            $this->loader = new \Twig_Loader_Filesystem(
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
    protected function getOptions()
    {
        $options = [];
        foreach($this->optionsMap as $property => $name) {
            $options[$name] = $this->$property;
        }
        return $options;
    }
}
