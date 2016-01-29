<?php

/*
 * This file is part of the Laravel Maintenance package.
 *
 * (c) Claude Khedhiri <khedhiri@madewithcaffeine.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mwc\Laravel\Maintenance\Test;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('maintenance', array(
            'driver' => 'file',
            'path' => storage_path('framework'),
            'urls' => array(
                'welcome'
            ),
            'excepts' => array(
                'ips' => array(
                    '127.0.0.1'
                ),
                'env' => array(
                    'local'
                ),
            ),
            'view' => 'maintenance::default'
        ));

        $app['router']->get('/', function () {
            return 'Welcome';
        });
    }

    /**
     * Resolve application Console Kernel implementation.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function resolveApplicationConsoleKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Console\Kernel', 'Mwc\Laravel\Maintenance\Test\Console\Kernel');
    }

    /**
     * Resolve application HTTP Kernel implementation.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Mwc\Laravel\Maintenance\Test\Http\Kernel');
    }

    /**
     * Get Laravel Maintenance package providers.
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return array('Mwc\Laravel\Maintenance\MaintenanceService');
    }

    /**
     * Resolve application package alias.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return array(
            'Maintenance' => 'Mwc\Laravel\Maintenance\Facades\MaintenanceFacade'
        );
    }
}
