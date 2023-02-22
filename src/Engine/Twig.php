<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Engine;

use Slick\Template\TemplateEngineInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;

/**
 * Twig
 *
 * @package Slick\Template\Engine
 */
class Twig implements TemplateEngineInterface
{

    private array $optionsMap = [
        'debug' => 'debug',
        'autoEscape' => 'html',
        'strictVariables' => 'strict_variables',
        'autoReload' => 'auto_reload',
        'cache' => 'cache',
        'baseTemplateClass' => 'base_template_class',
        'charset' => 'charset',
        'optimizations' => 'optimizations'
    ];

    private array $defaultOptions = [
        'debug' => false,
        'autoEscape' => true,
        'strictVariables' => false,
        'autoReload' => false,
        'cache' => false,
        'baseTemplateClass' => 'Twig_Template',
        'charset' => 'utf8',
        'optimizations' => -1
    ];

    private array $options ;

    private array $locations = [];

    private ?FilesystemLoader $loader = null;

    private ?TemplateWrapper $template = null;

    /**
     * Creates a Twig template engine
     *
     * @param array $options
     * @param Environment|null $twigEnvironment
     */
    public function __construct(array $options = [], private ?Environment $twigEnvironment = null)
    {
        $this->options = array_merge($this->defaultOptions, $options);
    }

    /**
     * Engine configuration options
     *
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * Parses the source template code.
     *
     * @param string $source The template to parse
     *
     * @return Twig
     *
     * @throws LoaderError When the template cannot be found
     * @throws RuntimeError When a previously generated cache is corrupted
     * @throws SyntaxError When an error occurred during compilation
     */
    public function parse($source): self
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
    public function process($data = array()): string
    {
        return $this->template->render($data);
    }

    /**
     * Sets the list of available locations for template files.
     *
     * @param array $locations
     *
     * @return Twig
     */
    public function setLocations(array $locations): self
    {
        $this->locations = $locations;
        return $this;
    }

    /**
     * Returns the source template engine
     *
     * @return Environment
     */
    public function getSourceEngine(): Environment
    {
        return $this->getTwigEnvironment();
    }

    /**
     * Creates a twig environment if not injected
     *
     * @return Environment
     */
    private function getTwigEnvironment(): Environment
    {
        if (null == $this->twigEnvironment) {
            $this->twigEnvironment = $this->createTwigEnvironment();
        }
        return $this->twigEnvironment;
    }


    /**
     * Creates the twig environment
     *
     * @return Environment
     */
    private function createTwigEnvironment(): Environment
    {
        $twigEnv = new Environment(
            $this->getLoader(),
            $this->getOptions()
        );

        if ($this->options['debug']) {
            $twigEnv->addExtension(new DebugExtension());
        }

        return $twigEnv;
    }

    /**
     * Creates a file system loader
     *
     * @return FilesystemLoader
     */
    private function getLoader(): FilesystemLoader
    {
        if (null == $this->loader) {
            $this->loader = new FilesystemLoader(
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
    private function getOptions(): array
    {
        $options = [];
        foreach ($this->optionsMap as $property => $name) {
            $options[$name] = $this->options[$property];
        }
        return $options;
    }
}
