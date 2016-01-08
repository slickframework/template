<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template;

use Slick\Template\Exception\ParserException;

/**
 * Template Engine interface
 *
 * @package Slick\Template
 * @author  Filipe Silva <silvam.filipe@gmail.com>
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
     * @throws ParserException If any error occurs parsing the template
     */
    public function parse($source);

    /**
     * Processes the template with data to produce the final output.
     *
     * @param mixed $data The data that will be used to process the view.
     *
     * @return string Returns processed output string.
     */
    public function process($data = array());

    /**
     * Sets the list of available locations for template files.
     *
     * @param array $locations
     *
     * @return TemplateEngineInterface|self|$this
     */
    public function setLocations(array $locations);
}
