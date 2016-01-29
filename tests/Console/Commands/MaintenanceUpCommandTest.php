<?php

/*
 * This file is part of the Laravel Maintenance package.
 *
 * (c) Claude Khedhiri <khedhiri@madewithcaffeine.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mwc\Laravel\Maintenance\Test\Console\Commands;

use Mwc\Laravel\Maintenance\Test\TestCase;

/**
 * Class DownCommandTest
 */
class MaintenanceCommandTest extends TestCase
{
    /**
     * Basic Test DownCommand.
     *
     * @test
     */
    public function testMaintenanceUp()
    {
        $this->app['config']->set('maintenance', array(
            'path' => storage_path('app')
        ));

        $this->artisan('maintenance:up');

        $this->get('/')->seeStatusCode('503');
    }
}
