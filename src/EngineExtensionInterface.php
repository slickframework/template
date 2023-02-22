<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template;

/**
 * Engine Extension interface
 *
 * @package Slick\Template
 */
interface EngineExtensionInterface
{

    /**
     * Updates the engine with this extension
     *
     * @param TemplateEngineInterface $engine
     *
     * @return void
     */
    public function update(TemplateEngineInterface $engine): void;

    /**
     * Check if this extension is applicable to provided engine object
     *
     * @param TemplateEngineInterface $engine
     *
     * @return bool True if this extension applies to provided engine object
     *      or false otherwise
     */
    public function appliesTo(TemplateEngineInterface $engine): bool;
}
