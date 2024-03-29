<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template;

use RuntimeException;
use Slick\Template\Exception\ParserException;

/**
 * Template Engine interface
 *
 * @package Slick\Template
 */
interface TemplateEngineInterface
{

    /**
     * Parses the source template code.
     *
     * @param string $source The template to parse
     *
     * @return TemplateEngineInterface|self|$this
     *
     * @throws RuntimeException If any error occurs parsing the template
     */
    public function parse($source): self;

    /**
     * Processes the template with data to produce the final output.
     *
     * @param mixed $data The data that will be used to process the view.
     *
     * @return string Returns processed output string.
     */
    public function process($data = array()): string;

    /**
     * Sets the list of available locations for template files.
     *
     * @param array $locations
     *
     * @return TemplateEngineInterface|self|$this
     */
    public function setLocations(array $locations): self;

    /**
     * Returns the source template engine
     *
     * @return object
     */
    public function getSourceEngine(): object;
}
