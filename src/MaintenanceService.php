<?php

/*
 * This file is part of the Laravel Maintenance package.
 *
 * (c) Claude Khedhiri <khedhiri@madewithcaffeine.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mwc\Laravel\Maintenance;

use Illuminate\Support\ServiceProvider;
use Mwc\Laravel\Maintenance\Driver\FileDriver;

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
        $configPath = __DIR__ . '/../config/maintenance.php';

        $this->mergeConfigFrom($configPath, 'maintenance');

        $this->publishes(array(
            $configPath => config_path('maintenance.php')
        ), 'config');
    }

    /**
     * Register the commands
     *
     * @return void
     */
    public function register()
    {
        $this->registerMaintenanceDrivers();
        $this->registerMaintenance();
        $this->registerMaintenanceCommand();
    }

    protected function registerMaintenance()
    {
        $this->app->singleton('maintenance', function ($app) {

            /*
             * @var \Illuminate\Config\Repository;
             */
            $config = $app['config'];

            return new Maintenance($config, $app['maintenance.'. $config->get('maintenance.driver') .'.driver']);
        });

        $this->app->alias('maintenance', 'Mwc\Laravel\Maintenance\Maintenance');
    }

    protected function registerMaintenanceDrivers()
    {
        $this->app->bind('maintenance.file.driver', function ($app) {
            return new FileDriver($app);
        });

        $this->app->alias('maintenance.file.driver', 'Mwc\Laravel\Maintenance\Driver\FileDriver');
    }

    protected function registerMaintenanceCommand()
    {
        $this->app->singleton('command.maintenance.up', function ($app) {
            return $app['Mwc\Laravel\Maintenance\Console\Commands\MaintenanceUpCommand'];
        });

        $this->app->singleton('command.maintenance.down', function ($app) {
            return $app['Mwc\Laravel\Maintenance\Console\Commands\MaintenanceDownCommand'];
        });

        $this->commands('command.maintenance.up');

        $this->commands('command.maintenance.down');
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
            'maintenance.manager',
            'command.maintenance.up',
            'command.maintenance.down'
        );
    }
}
