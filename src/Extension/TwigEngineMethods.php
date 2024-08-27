<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\Extension;

use Slick\Template\Engine\TwigTemplateEngine;
use Slick\Template\Extension\Twig\TwigTextExtension;
use Slick\Template\TemplateEngineInterface;
use Twig\Extension\ExtensionInterface;

/**
 * TwigEngineMethods
 *
 * @package Slick\Template\Extension
 */
trait TwigEngineMethods
{

    /**
     * @inheritDoc
     */
    public function update(TemplateEngineInterface $engine): void
    {
        if ($engine instanceof TwigTemplateEngine) {
            /** @var ExtensionInterface $class */
            $class = $this->twigExtensionName;
            $engine->sourceEngine()->addExtension(new $class());
        }
    }

    /**
     * @inheritDoc
     */
    public function appliesTo(TemplateEngineInterface $engine): bool
    {
        return $engine instanceof TwigTemplateEngine;
    }
}
