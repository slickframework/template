<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\Engine;

use Slick\Template\Engine\MarkdownLoader;
use PHPUnit\Framework\TestCase;
use Twig\Extra\Markdown\MarkdownRuntime;

class MarkdownLoaderTest extends TestCase
{

    public function testLoad(): void
    {
        $loader = new MarkdownLoader();
        $runTime = $loader->load(MarkdownRuntime::class);
        $this->assertInstanceOf(MarkdownRuntime::class, $runTime);
    }
}
