<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\UserInterface;

use Prophecy\PhpUnit\ProphecyTrait;
use Slick\Template\TemplateEngineInterface;
use Slick\Template\UserInterface\TemplateMethods;
use PHPUnit\Framework\TestCase;

class TemplateMethodsTest extends TestCase
{
    use TemplateMethods;
    use ProphecyTrait;

    public function testRender(): void
    {
        $engine = $this->prophesize(TemplateEngineInterface::class);
        $source = 'test.twig';
        $data = ['foo' => 'bar'];
        $engine->parse($source)->shouldBeCalled()->willReturn($engine->reveal());
        $content = 'Test';
        $engine->process($data)->shouldBeCalled()->willReturn($content);
        $this->withTemplateEngine($engine->reveal());

        $response = $this->render($source, $data);
        $this->assertEquals(200, $response->getStatusCode());
        $response->getBody()->rewind();
        $responseContent = (string) $response->getBody();
        $this->assertEquals($content, $responseContent);
    }
}
