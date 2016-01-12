<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Extension;

use Slick\Template\Engine\Twig;
use Slick\Template\EngineExtensionInterface;
use Slick\Template\TemplateEngineInterface;

/**
 * Twig text utility extension for Slick/Template
 *
 * @package Slick\Template\Extension
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Text extends AbstractTwigExtension implements EngineExtensionInterface
{

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Text utilities extension';
    }

    /**
     * Returns a list of filters
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'truncate',
                function ($value, $len=75, $ter='...', $preserve = false) {
                    return \Slick\Common\Utils\Text::truncate(
                        $value,
                        $len,
                        $ter,
                        $preserve
                    );
                }
            ),
            new \Twig_SimpleFilter(
                'wordwrap',
                function ($value, $length = 75, $break = "\n", $cut = false) {
                    return \Slick\Common\Utils\Text::wordwrap(
                        $value,
                        $length,
                        $break,
                        $cut
                    );
                }
            )
        ];
    }
}