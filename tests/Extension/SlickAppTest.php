<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\Extension;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Configuration\ConfigurationInterface;
use Slick\Configuration\Driver\Environment;
use Slick\Template\Extension\SlickApp;
use Slick\WebStack\Domain\Security\SecurityAuthenticatorInterface;
use Slick\WebStack\Domain\Security\UserInterface;
use Slick\WebStack\Infrastructure\Http\FlashMessageInterface;
use Slick\WebStack\Infrastructure\Http\FlashMessageStorage;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SlickAppTest extends TestCase
{

    use ProphecyTrait;

    public function testConstruct(): void
    {
        $user = $this->prophesize(UserInterface::class)->reveal();
        $auth = $this->prophesize(SecurityAuthenticatorInterface::class);
        $flash = $this->prophesize(FlashMessageStorage::class)->reveal();
        $generator = $this->prophesize(UrlGeneratorInterface::class)->reveal();
        $auth->enabled()->willReturn(true);
        $auth->user()->willReturn($user);

        $app = new SlickApp($auth->reveal(), null, null, $generator, $flash);
        $this->assertSame($user, $app->user());
        $this->assertSame($flash, $app->flash());
        $this->assertSame($generator, $app->generator());
    }

    public function testRequest(): void
    {
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();
        $app = new SlickApp(request: $request);
        $this->assertSame($request, $app->request());
    }

    public function testMissingUser(): void
    {
        $app = new SlickApp();
        $this->assertNull($app->user());
    }

    public function testSettings(): void
    {
        $request = $this->prophesize(ConfigurationInterface::class)->reveal();
        $app = new SlickApp(settings: $request);
        $this->assertSame($request, $app->settings());

        $app = new SlickApp();
        $this->assertInstanceOf(Environment::class, $app->settings());
    }
}
