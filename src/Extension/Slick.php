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
use Slick\Template\EngineExtensionInterface;
use Slick\Template\Extension\Twig\TwigSlickExtension;
use Slick\Template\TemplateEngineInterface;

/**
 * Slick
 *
 * @package Slick\Template\Extension
 */
final class Slick implements EngineExtensionInterface
{

    use TwigEngineMethods;

    public function __construct(private readonly SlickApp $app)
    {
    }

    protected string $twigExtensionName = TwigSlickExtension::class;

    public function update(TemplateEngineInterface $engine): void
    {
        if ($engine instanceof TwigTemplateEngine) {
            $engine->sourceEngine()->addExtension(new TwigSlickExtension($this->app));
        }
    }


}
