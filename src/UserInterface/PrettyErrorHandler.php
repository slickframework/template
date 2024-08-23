<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\UserInterface;

use Slick\ErrorHandler\Exception\ExceptionInspector;
use Slick\ErrorHandler\Handler\HandlerInterface;
use Slick\ErrorHandler\RunnerInterface;
use Slick\Template\Engine\TwigTemplateEngine;
use Slick\Template\TemplateEngineInterface;
use Throwable;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

/**
 * PrettyErrorHandler
 *
 * @package Slick\Template\UserInterface
 */
final class PrettyErrorHandler implements HandlerInterface
{

    public function __construct(private readonly TemplateEngineInterface $engine)
    {
    }

    public static function create(): static
    {
        $path = dirname(dirname(__DIR__)) . '/templates';
        $loader = new FilesystemLoader([$path]);
        $twig = new Environment($loader, ['cache' => false, 'debug' => true]);
        $twig->addExtension(new DebugExtension());
        $twig->addExtension(new MarkdownExtension());
        $twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
            public function load($class) {
                if (MarkdownRuntime::class === $class) {
                    return new MarkdownRuntime(new DefaultMarkdown());
                }
            }
        });
        $templateEngine = new TwigTemplateEngine($twig);

        return new static($templateEngine);
    }

    public function handle(Throwable $throwable, ExceptionInspector $inspector, RunnerInterface $runner): ?int
    {
        $handler = $this;
        $runner->sendResponseCode($inspector->statusCode());

        echo $this->engine
            ->parse('errors/exception.twig')
            ->process(compact('throwable', 'inspector', 'runner', 'handler'));
        return self::QUIT;
    }

    public function functionCall(Throwable $throwable, int $key): string
    {
        $lines = explode("#", $throwable->getTraceAsString());
        $line = $lines[$key];
        $parts = explode(":", $line);
        return trim(end($parts));
    }


    public function version(): string
    {
        $composerFile = dirname(__DIR__, 3) . '/webstack/composer.json';
        $file = is_file($composerFile)
            ? $composerFile
            : dirname(dirname(__DIR__)) . '/vendor/slick/webstack/composer.json';

        $composer = json_decode(file_get_contents($file));
        return $composer->version;
    }
}
