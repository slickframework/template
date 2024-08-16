<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\Engine;

use Prophecy\PhpUnit\ProphecyTrait;
use Slick\Template\Engine\TwigTemplateEngine;
use PHPUnit\Framework\TestCase;
use Slick\Template\Exception\MissingParsedTemplate;
use Slick\Template\TemplateEngineInterface;
use Twig\Environment;
use Twig\Template;
use Twig\TemplateWrapper;

class TwigTemplateEngineTest extends TestCase
{
    use ProphecyTrait;

    public function testInitialization(): void
    {
        $environment = $this->prophesize(Environment::class)->reveal();
        $engine = new TwigTemplateEngine($environment);
        $this->assertInstanceOf(TwigTemplateEngine::class, $engine);
        $this->assertInstanceOf(TemplateEngineInterface::class, $engine);
    }

    public function testParse(): void
    {
        $environment = $this->prophesize(Environment::class);
        $template = $this->prophesize(Template::class)->reveal();
        $name = '@templates/index.html.twig';
        $environment->load($name)->shouldBeCalled()->willReturn(new TemplateWrapper($environment->reveal(), $template));
        $engine = new TwigTemplateEngine($environment->reveal());
        $parsed = $engine->parse($name);
        $this->assertInstanceOf(TemplateEngineInterface::class, $parsed);
        $this->assertNotSame($engine, $parsed);
    }

    public function testProcess(): void
    {
        $environment = $this->prophesize(Environment::class);
        $template = $this->prophesize(Template::class);
        $template->render(['foo' => 'bar'])->shouldBeCalled()->willReturn('foo');
        $name = '@templates/index.html.twig';
        $environment
            ->load($name)
            ->shouldBeCalled()
            ->willReturn(new TemplateWrapper($environment->reveal(), $template->reveal()))
        ;
        $engine = new TwigTemplateEngine($environment->reveal());
        $this->assertEquals('foo', $engine->parse($name)->process(['foo' => 'bar']));
    }

    public function testMissingTemplate()
    {
        $this->expectException(MissingParsedTemplate::class);
        $environment = $this->prophesize(Environment::class)->reveal();
        $engine = new TwigTemplateEngine($environment);
        $this->assertNull($engine->process(['foo' => 'bar']));
    }

    public function testGetSource(): void
    {
        $environment = $this->prophesize(Environment::class)->reveal();
        $engine = new TwigTemplateEngine($environment);
        $this->assertSame($environment, $engine->sourceEngine());
    }
}
