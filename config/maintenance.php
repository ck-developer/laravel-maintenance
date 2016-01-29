<?php

/*
 * This file is part of the Laravel Maintenance package.
 *
 * (c) Claude Khedhiri <khedhiri@madewithcaffeine.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return array(
    'driver' => 'file',     # Driver file|redis,
    'path' => storage_path('app'),
    'excepts' => array(
        'ips' => array(
            '127.0.0.1'
        ),
        'routes' => array(
            'welcome'
        ),
        'env' => array(
            'local'
        ),
    ),
    'view' => 'maintenance::default'
);
