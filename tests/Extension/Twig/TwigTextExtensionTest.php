<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\Extension\Twig;

use Slick\Template\Extension\Twig\TwigTextExtension;
use PHPUnit\Framework\TestCase;

class TwigTextExtensionTest extends TestCase
{

    public function testTruncate(): void
    {
        $ext = new TwigTextExtension();
        $filter = $ext->getFilters()[0];
        $this->assertEquals("This is a...", $filter->getCallable()("This is a test", 9));
        $this->assertEquals("This is a test", $filter->getCallable()("This is a test", 15));
    }

    public function testWordWrap(): void
    {
        $ext = new TwigTextExtension();
        $filter = $ext->getFilters()[1];
        $this->assertEquals("This is a\ntest", $filter->getCallable()("This is a test", 9));
    }
}
