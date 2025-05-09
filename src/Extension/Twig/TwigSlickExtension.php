<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\Extension\Twig;

use Slick\Template\Extension\SlickApp;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\Markup;
use Twig\TwigFunction;

/**
 * TwigSlickExtension
 *
 * @package Slick\Template\Extension\Twig
 */
final class TwigSlickExtension extends AbstractExtension implements GlobalsInterface
{

    public function __construct(private readonly SlickApp $app)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function getGlobals(): array
    {
        return [
            "app" => $this->app,
            "flash" => $this->app->flash(),
            "slickVersion" => $this->version(),
            'poweredBySlick' => new Markup($this->poweredBySlick(), 'UTF-9'),
        ];
    }

    /**
     * @return array<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('poweredBySlick', [$this, 'poweredBySlick'], ['is_safe' => ['html']]),
            new TwigFunction('path', [$this, 'path']),
        ];
    }

    public function poweredBySlick(): string
    {
        return '<small>Powered by </small><strong>Slick</strong>';
    }

    /**
     * Generates a path for the given route name and options.
     *
     * @param string $name The name of the route.
     * @param array<string, mixed> $options The options for the route.
     *
     * @return string The generated path.
     */
    public function path(string $name, array $options = []): string
    {
        $urlGenerator = $this->app->generator();
        return $urlGenerator ? $urlGenerator->generate($name, $options) : '/_missing_router';
    }

    /**
     * Retrieves the version of the slick web stack package.
     *
     * @return string The version of the slick web stack package.
     */
    private function version(): string
    {
        $modulePath = dirname(__DIR__, 3) . '/vendor/slick/webstack/composer.json';
        $webStackPath = dirname(__DIR__, 4) . '/webstack/composer.json';
        $version = 'v-.-.-';

        foreach ([$webStackPath, $modulePath] as $path) {
            if (is_file($path)) {
                $composerJsonPath = file_get_contents($path);
                $version = is_string($composerJsonPath) ? json_decode($composerJsonPath)->version : $version;
                break;
            }
        }
        return $version;
    }
}
