<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template;


/**
 * EngineInterface
 *
 * @package   Slick\Template
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
interface EngineInterface
{
    /**
     * Parses the source template code.
     *
     * @param string $source The template to parse
     *
     * @return EngineInterface Returns this instance for chaining methods calls
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
}
