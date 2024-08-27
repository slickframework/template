<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template\Extension;

use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Template\Extension\SlickApp;
use PHPUnit\Framework\TestCase;
use Slick\WebStack\Domain\Security\AuthorizationCheckerInterface;
use Slick\WebStack\Domain\Security\SecurityAuthenticatorInterface;
use Slick\WebStack\Domain\Security\UserInterface;

class SlickAppTest extends TestCase
{

    use ProphecyTrait;

    public function testUser(): void
    {
        $user = $this->prophesize(UserInterface::class)->reveal();
        $auth = $this->prophesize(SecurityAuthenticatorInterface::class);
        $auth->enabled()->willReturn(true);

        $security = $this->prophesize(AuthorizationCheckerInterface::class);
        $security->authenticatedUser()->willReturn($user);

        $app = new SlickApp($security->reveal(), $auth->reveal());
        $this->assertSame($user, $app->user());
    }

    public function testRequest(): void
    {
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();
        $app = new SlickApp(request: $request);
        $this->assertSame($request, $app->request());
    }
}
