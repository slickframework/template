<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\Engine;

use PHP_CodeSniffer\Generators\Markdown;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

/**
 * MarkdownLoader
 *
 * @package Slick\Template\Engine
 */
final class MarkdownLoader implements RuntimeLoaderInterface
{

    /**
     * @inheritDoc
     */
    public function load(string $class): ?MarkdownRuntime
    {
        return (MarkdownRuntime::class === $class)
            ? new MarkdownRuntime(new DefaultMarkdown())
            : null;
    }
}
