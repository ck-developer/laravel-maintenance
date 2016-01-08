<?php

/*
 * This file is part of the LaravelMaintenance package.
 *
 * (c) Claude Khedhiri <claude@khedhiri.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ck\Laravel\Maintenance;

use Illuminate\Support\ServiceProvider;

class MaintenanceService extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Booting
     */
    public function boot()
    {
    }

    /**
     * Register the commands
     *
     * @return void
     */
    public function register()
    {
        $this->registerUpCommand();
        $this->registerDownCommand();
        $this->registerMaintenance();
    }

    protected function registerMaintenance()
    {
        $this->app->singleton('maintenance', function ($app) {
            return new Maintenance($app);
        });

        $this->app->alias('maintenance', 'Ck\Laravel\Maintenance\Maintenance');
    }

    protected function registerUpCommand()
    {
        $this->app->singleton('command.up', function ($app) {
            return $app['Ck\Laravel\Maintenance\Console\Commands\UpCommand'];
        });

        $this->commands('command.up');
    }

    protected function registerDownCommand()
    {
        $this->app->singleton('command.down', function ($app) {
            return $app['Ck\Laravel\Maintenance\Console\Commands\DownCommand'];
        });

        $this->commands('command.down');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'maintenance',
            'command.down',
            'command.up'
        );
    }
}
