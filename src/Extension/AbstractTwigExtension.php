<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Extension;

use Slick\Template\Engine\Twig;
use Slick\Template\TemplateEngineInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;

/**
 * Abstract Twig Extension
 *
 * @package Slick\Template\Extension
 */
abstract class AbstractTwigExtension extends AbstractExtension implements ExtensionInterface
{

    /**
     * Updates the engine with this extension
     *
     * @param TemplateEngineInterface|Twig $engine
     *
     * @return void
     */
    public function update(TemplateEngineInterface $engine): void
    {
        $engine->getSourceEngine()->addExtension($this);
    }

    /**
     * Check if this extension is applicable to provided engine object
     *
     * @param TemplateEngineInterface $engine
     *
     * @return bool True if this extension applies to provided engine object
     *      or false otherwise
     */
    public function appliesTo(TemplateEngineInterface $engine): bool
    {
        return $engine instanceof Twig;
    }
}
