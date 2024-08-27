<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\UserInterface;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Slick\ErrorHandler\Exception\ExceptionInspector;
use Slick\ErrorHandler\Handler\HandlerInterface;
use Slick\ErrorHandler\RunnerInterface;
use Slick\Template\TemplateEngineInterface;
use Slick\Template\UserInterface\PrettyErrorHandler;
use PHPUnit\Framework\TestCase;

class PrettyErrorHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testCreate():void
    {
        $handler = PrettyErrorHandler::create();
        $this->assertInstanceOf(PrettyErrorHandler::class, $handler);
        $this->assertInstanceOf(HandlerInterface::class, $handler);
    }

    public function testFunctionCall(): void
    {
        $engine = $this->prophesize(TemplateEngineInterface::class)->reveal();

        $exp = new \Exception('test');
        $handler = new PrettyErrorHandler($engine);
        $this->assertIsString($handler->functionCall($exp, 1));
    }

    public function testHandle(): void
    {
        $throwable = $this->prophesize(\Throwable::class)->reveal();
        $inspector = $this->prophesize(ExceptionInspector::class);
        $runner = $this->prophesize(RunnerInterface::class);
        $runner->sendResponseCode(200)->shouldBeCalled();
        $inspector->statusCode()->willReturn(200)->shouldBeCalled();

        $engine = $this->prophesize(TemplateEngineInterface::class);

        $handler = new PrettyErrorHandler($engine->reveal());

        $engine->parse('errors/exception.twig')->willReturn($engine);
        $engine->process([
            'throwable' => $throwable,
            'inspector' => $inspector->reveal(),
            'runner' => $runner->reveal(),
            'handler' => $handler
        ])->shouldBeCalled()->willReturn('');
        $this->assertEquals($handler::QUIT, $handler->handle($throwable, $inspector->reveal(), $runner->reveal()));
    }
}
