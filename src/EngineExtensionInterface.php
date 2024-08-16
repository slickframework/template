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
 * EngineExtensionInterface
 *
 * @package Slick\Template
 */
interface EngineExtensionInterface
{

    /**
     * Enhances or modifies the provided engine with the features of this extension.
     *
     * @param TemplateEngineInterface $engine The engine that is to be updated and extended with this extension.
     *
     * @return void
     */
    public function update(TemplateEngineInterface $engine): void;

    /**
     * Determines if this extension can be applied to the provided engine.
     *
     * @param TemplateEngineInterface $engine The engine that is being tested for compatibility with this extension.
     *
     * @return bool Returns true if this extension is compatible and can be applied to the
     * provided engine. Returns false if this extension does not apply or is incompatible with the engine.
     */
    public function appliesTo(TemplateEngineInterface $engine): bool;
}
