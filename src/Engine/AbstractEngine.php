<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Engine;

use Slick\Common\Base;
use Slick\Template\TemplateEngineInterface;

/**
 * AbstractEngine
 *
 * @package   Slick\Template\Engine
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
abstract class AbstractEngine extends Base implements TemplateEngineInterface
{
    /**
     * Handles the initialization if engine is already initialized
     *
     * @return AbstractEngine|self|$this
     */
    public function initialize()
    {
        return $this;
    }
}
