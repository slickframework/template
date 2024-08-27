<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\Extension;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Slick\Template\Engine\TwigTemplateEngine;
use Slick\Template\Extension\Text;
use PHPUnit\Framework\TestCase;
use Slick\Template\Extension\Twig\TwigTextExtension;
use Slick\Template\TemplateEngineInterface;
use Twig\Environment;

class TextTest extends TestCase
{
    use ProphecyTrait;

    public function testAppliesTo(): void
    {
        $twig = $this->prophesize(Environment::class)->reveal();
        $engine = new TwigTemplateEngine($twig);
        $ext = new Text();
        $this->assertTrue($ext->appliesTo($engine));

        $engine = $this->prophesize(TemplateEngineInterface::class)->reveal();
        $this->assertFalse($ext->appliesTo($engine));
    }

    public function testUpdate(): void
    {
        $twig = $this->prophesize(Environment::class);
        $twig->addExtension(Argument::type(TwigTextExtension::class))
            ->shouldBeCalled();
        $engine = new TwigTemplateEngine($twig->reveal());
        $ext = new Text();
        $ext->update($engine);
    }
}
