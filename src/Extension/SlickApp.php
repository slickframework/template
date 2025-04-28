<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\Extension;

use Psr\Http\Message\ServerRequestInterface;
use Slick\Configuration\ConfigurationInterface;
use Slick\Configuration\Driver\Environment;
use Slick\WebStack\Domain\Security\SecurityAuthenticatorInterface;
use Slick\WebStack\Domain\Security\UserInterface;
use Slick\WebStack\Infrastructure\Http\FlashMessageStorage;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * SlickApp
 *
 * @package Slick\Template\Extension
 */
class SlickApp
{
    /**
     * Creates a SlickApp
     *
     * @param SecurityAuthenticatorInterface|null $authenticator
     * @param ServerRequestInterface|null $request
     * @param ConfigurationInterface|null $settings
     * @param UrlGeneratorInterface|null $generator
     * @param FlashMessageStorage|null $flash
     */
    public function __construct(
        private readonly ?SecurityAuthenticatorInterface $authenticator = null,
        private readonly ?ServerRequestInterface $request = null,
        private readonly ?ConfigurationInterface $settings = null,
        private readonly ?UrlGeneratorInterface $generator = null,
        private readonly ?FlashMessageStorage $flash = null
    ) {
    }

    /**
     * Retrieves the authenticated user, if available.
     *
     * @return UserInterface|null The authenticated user, or null if not authenticated.
     */
    public function user(): ?UserInterface
    {
        if ($this->authenticator && $this->authenticator->enabled()) {
            return $this->authenticator->user();
        }
        return null;
    }

    /**
     * Retrieve the server request.
     *
     * @return ServerRequestInterface|null The server request object, or null if not set.
     */
    public function request(): ?ServerRequestInterface
    {
        return $this->request;
    }

    public function settings(): ConfigurationInterface
    {
        if (!$this->settings) {
            return new Environment();
        }
        return $this->settings;
    }

    public function generator(): ?UrlGeneratorInterface
    {
        return $this->generator;
    }

    public function flash(): ?FlashMessageStorage
    {
        return $this->flash;
    }
}
