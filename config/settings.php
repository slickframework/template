<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Config;

$settings = [
    'template' => [
        'paths' => [
            dirname(__DIR__) . '/templates'
        ],
        'options' => [
            'debug' => false,
            'charset' => 'utf-8',
            'cache' => false,
            'strict_variables' => false,
            'optimizations' => -1
        ],
        'framework' => 'bulma', //bulma or boostrap
        'theme' => 'sandstone'
    ]
];


return $settings;
