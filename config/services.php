<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace config\services;

use Slick\Configuration\ConfigurationInterface;
use Slick\Di\Container;
use Slick\Template\Engine\TwigTemplateEngine;
use Slick\Template\EngineExtensionInterface;
use Slick\Template\Extension\Slick;
use Slick\Template\Extension\SlickApp;
use Slick\Template\TemplateEngineInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

$services = [];

$services[TemplateEngineInterface::class] = '@template.engine';
$services['template.engine'] = function (Container $container) {
    $settings = $container->get(ConfigurationInterface::class);
    $paths = [];
    $namespaced = [];
    foreach ($settings->get('template.paths', []) as $name => $path) {
        if (is_string($name)) {
            $namespaced[$name] = $path;
            continue;
        }
        $paths[] = $path;
    }

    $loader = new FilesystemLoader($paths);
    foreach ($namespaced as $name => $path) {
        $loader->addPath($path, $name);
    }
    $options = $settings->get('template.options', []);
    $templateEngine = new TwigTemplateEngine(new Environment($loader, $options));
    $slick = new Slick($container->make(SlickApp::class));
    $slick->update($templateEngine);

    if (isset($options['debug']) && $options['debug']) {
        $templateEngine->sourceEngine()->addExtension(new DebugExtension());
    }

    foreach ($settings->get('template.extensions', []) as $ext) {
        if ($ext instanceof EngineExtensionInterface && $ext->appliesTo($templateEngine)) {
            $ext->update($templateEngine);
        }
    }
    return $templateEngine;
};

return $services;
