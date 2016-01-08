<?php

/*
 * This file is part of the LaravelMaintenance package.
 *
 * (c) Claude Khedhiri <claude@khedhiri.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ck\Laravel\Maintenance\Test;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Resolve application Console Kernel implementation.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function resolveApplicationConsoleKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Console\Kernel', 'Ck\Laravel\Maintenance\Test\Console\Kernel');
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
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Ck\Laravel\Maintenance\Test\Http\Kernel');
    }

    /**
     * Get Laravel Maintenance package providers.
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return array('Ck\Laravel\Maintenance\MaintenanceService');
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
            'Maintenance' => 'Ck\Laravel\Maintenance\Facades\MaintenanceFacade'
        );
    }
}
