<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Engine;

use Slick\Template\Engine\Twig\SlickTwigExtension;
use Slick\Template\EngineInterface;
use Slick\Template\Exception\ParserException;

/**
 * Twig
 *
 * @package   Slick\Template\Engine
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 *
 * @property \Twig_Environment $twig
 *
 * @method string getSource()
 */
class Twig extends AbstractEngine
{
    /**
     * @read
     * @var string The template source file.
     */
    protected $_source;
    /**
     * @readwrite
     * @var array The list of paths where to find template fields
     * order maters.
     */
    protected $_paths = array();
    /**
     * @readwrite
     * @var \Twig_Environment Twig engine
     */
    protected $_twig;
    /**
     * Parses the source template code.
     *
     * @param string $source The template to parse
     *
     * @return EngineInterface Returns this instance for chaining methods calls
     */
    public function parse($source)
    {
        $this->_source = $source;
        return $this;
    }
    /**
     * Processes the template with data to produce the final output.
     *
     * @param mixed $data The data that will be used to process the view.
     *
     * @throws \Slick\Template\Exception\ParserException
     *
     * @return string Returns processed output string.
     */
    public function process($data = array())
    {
        try {
            return $this->getTwig()->render($this->_source, $data);
        } catch (\Twig_Error $exp) {
            throw new ParserException(
                "Error Processing Request: " . $exp->getMessage()
            );
        }
    }
    /**
     * Lazy loading of twig library
     *
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        if (is_null($this->_twig)) {
            $this->_twig = new \Twig_Environment(
                new \Twig_Loader_Filesystem($this->_paths),
                [
                    'debug' => true,
                ]
            );
            $this->_twig->addExtension(new \Twig_Extension_Debug());
            $this->_twig->addExtension(new SlickTwigExtension());
        }
        return $this->_twig;
    }
}