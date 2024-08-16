<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template;

/**
 * TemplateEngineInterface
 *
 * @package Slick\Template
 */
interface TemplateEngineInterface
{
    /**
     * Parses the given source and returns an instance of the current class.
     *
     * @param string $source The source template file path to be parsed.
     * @return self The instance of the current class.
     * @throws TemplateException Whenever an error occurs during parse
     */
    public function parse(string $source): self;

    /**
     * Processes the template with given data and returns a string representation.
     *
     * @param array<string, mixed> $data The data to be processed. Default value is an empty array.
     * @return string The string representation of the processed template with data.
     */
    public function process(array $data = array()): string;

    /**
     * Returns the source template engine
     *
     * @return object
     */
    public function sourceEngine(): object;
}
