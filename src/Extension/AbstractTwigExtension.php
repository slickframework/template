<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Extension;

use Slick\Template\Engine\Twig;
use Slick\Template\TemplateEngineInterface;

/**
 * Abstract Twig Extension
 *
 * @package Slick\Template\Extension
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
abstract class AbstractTwigExtension extends \Twig_Extension
{

    /**
     * Updates the engine with this extension
     *
     * @param TemplateEngineInterface|Twig $engine
     *
     * @return void
     */
    public function update(TemplateEngineInterface $engine)
    {
        $engine->getSourceEngine()->addExtension($this);
    }

    /**
     * Check if this extension is applicable to provided engine object
     *
     * @param TemplateEngineInterface $engine
     *
     * @return bool True if this extension applies to provided engine object
     *      or false otherwise
     */
    public function appliesTo(TemplateEngineInterface $engine)
    {
        return $engine instanceOf Twig;
    }
}
