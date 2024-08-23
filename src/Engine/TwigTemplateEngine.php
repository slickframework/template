<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\Engine;

use Slick\Template\Exception\MissingParsedTemplate;
use Slick\Template\TemplateEngineInterface;
use Twig\Environment;
use Twig\TemplateWrapper;

/**
 * TwigTemplateEngine
 *
 * @package Slick\Template\Engine
 */
final class TwigTemplateEngine implements TemplateEngineInterface
{
    private ?TemplateWrapper $template = null;

    public function __construct(private readonly Environment $twigEnvironment)
    {
    }

    public function parse(string $source): TemplateEngineInterface
    {
        $engine = clone $this;
        $engine->template = $this->twigEnvironment->load($source);
        return $engine;
    }

    public function process(array $data = array()): string
    {
        if (null === $this->template) {
            throw new MissingParsedTemplate(
                "You need to set a template before using the process() method. ".
                "Use TemplateEngine::parse() first."
            );
        }
        return $this->template->render($data);
    }

    public function sourceEngine(): Environment
    {
        return $this->twigEnvironment;
    }
}
