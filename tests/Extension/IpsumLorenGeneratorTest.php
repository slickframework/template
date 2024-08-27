<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\Extension;

use Slick\Template\Extension\IpsumLorenGenerator;
use PHPUnit\Framework\TestCase;

class IpsumLorenGeneratorTest extends TestCase
{

    public function testWord(): void
    {
        $generator = new IpsumLorenGenerator();
        $this->assertMatchesRegularExpression('/\w/i', $generator->word());
    }

    public function testParagraphs(): void
    {
        $generator = new IpsumLorenGenerator();
        $this->assertStringContainsString("\n", $generator->paragraphs(2));
    }

    public function testSentence(): void
    {
        $generator = new IpsumLorenGenerator();
        $this->assertMatchesRegularExpression('/\w+/i', $generator->sentence());
    }

    public function testParagraph()
    {
        $generator = new IpsumLorenGenerator();
        $this->assertMatchesRegularExpression('/[\w.]+/i', $generator->paragraph());
    }
}
