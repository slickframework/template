<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\UserInterface;

use Psr\Http\Message\ResponseInterface;
use Slick\Di\Definition\Attributes\Autowire;
use Slick\Http\Message\Response;
use Slick\Template\TemplateEngineInterface;

/**
 * TemplateMethods
 *
 * @package Slick\Template\UserInterface
 */
trait TemplateMethods
{
    protected ?TemplateEngineInterface $templateEngine = null;

    #[Autowire]
    public function withTemplate(TemplateEngineInterface $templateEngine): void
    {
        $this->templateEngine = $templateEngine;
    }

    /**
     * Renders a template with the given data, headers, and status code.
     *
     * @param string $template The path to the template file.
     * @param array<string, mixed> $data The data to be passed to the template.
     * @param array<string, string> $headers The headers to be set in the response.
     * @param int $statusCode The status code of the response. Defaults to 200.
     *
     * @return ResponseInterface The rendered template as a response.
     */
    protected function render(
        string $template,
        array $data = [],
        array $headers = ['Content-Type' => 'text/html'],
        int $statusCode = 200
    ): ResponseInterface {
        $content = $this->templateEngine->parse($template)->process($data);
        return new Response($statusCode, $content, $headers);
    }
}
