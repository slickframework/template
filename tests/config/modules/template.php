<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace config\modules;

return [
    'paths' => [dirname(__DIR__, 2) . '/templates'],
    'options' => [
        'debug' => true,
        'strict_variables' => true,
    ]
];
