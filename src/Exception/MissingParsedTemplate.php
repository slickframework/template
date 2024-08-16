<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\Exception;

use InvalidArgumentException;
use Slick\Template\TemplateException;

/**
 * MissingParsedTemplate
 *
 * @package Slick\Template\Exception
 */
final class MissingParsedTemplate extends InvalidArgumentException implements TemplateException
{

}
