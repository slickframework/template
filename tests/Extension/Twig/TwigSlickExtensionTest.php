<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\Extension\Twig;

use Prophecy\PhpUnit\ProphecyTrait;
use Slick\Template\Extension\SlickApp;
use Slick\Template\Extension\Twig\TwigSlickExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TwigSlickExtensionTest extends TestCase
{
    use ProphecyTrait;

    public function testVersion(): void
    {
        $slickApp = $this->prophesize(SlickApp::class)->reveal();
        $ext = new TwigSlickExtension($slickApp);
        $globals = $ext->getGlobals();
        $this->assertMatchesRegularExpression('/v\d+\.\d+\.\d+/i', $globals['slickVersion']);
    }

    public function testPoweredBy(): void
    {
        $slickApp = $this->prophesize(SlickApp::class)->reveal();
        $ext = new TwigSlickExtension($slickApp);
        $functions = $ext->getFunctions();
        $this->assertStringContainsString('Slick', $functions[0]->getCallable()());
    }

    public function testPath(): void
    {
        $slickApp = $this->prophesize(SlickApp::class);
        $generator = $this->prophesize(UrlGeneratorInterface::class);
        $homeUrl = '/?test=1';
        $generator->generate('home', ['test' => '1'])->willReturn($homeUrl);
        $slickApp->generator()->willReturn($generator->reveal());
        $ext = new TwigSlickExtension($slickApp->reveal());
        $path = $ext->getFunctions()[1]->getCallable();
        $this->assertEquals($homeUrl, $path('home', ['test' => '1']));
    }
}
