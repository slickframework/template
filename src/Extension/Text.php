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
use Slick\Template\Extension\Twig\TwigTextExtension;
use Slick\Template\TemplateEngineInterface;

/**
 * Text
 *
 * @package Slick\Template\Extension
 */
final class Text implements EngineExtensionInterface
{
    use TwigEngineMethods;

    protected string $twigExtensionName = TwigTextExtension::class;
}
