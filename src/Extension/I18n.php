<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Extension;

use Slick\I18n\TranslateMethods;
use Slick\Template\EngineExtensionInterface;

/**
 * I18n extension for slick/template
 *
 * @package Slick\Template\Extension
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class I18n extends AbstractTwigExtension implements EngineExtensionInterface
{

    /**
     * Adds translation methods to this class
     */
    use TranslateMethods;

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'I18n extension';
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'translate',
                function ($message, $domain = null, $locale = null) {
                    return $this->translate($message, $domain, $locale);
                }
            ),
            new \Twig_SimpleFunction(
                'transPlural',
                function(
                    $singular, $plural, $number, $domain = null, $locale = null
                ) {
                    return $this->translatePlural(
                        $singular,
                        $plural,
                        $number,
                        $domain,
                        $locale
                    );
                }
            )
        ];
    }
}
