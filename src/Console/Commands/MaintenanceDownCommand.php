<?php

/*
 * This file is part of the Laravel Maintenance package.
 *
 * (c) Claude Khedhiri <khedhiri@madewithcaffeine.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mwc\Laravel\Maintenance\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Mwc\Laravel\Maintenance\Maintenance;

class MaintenanceDownCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put the application into maintenance mode';

    /**
     * @var Maintenance
     */
    protected $maintenance;

    public function __construct(Maintenance $maintenance)
    {
        parent::__construct();

        $this->maintenance = $maintenance;
    }

    /**
     * Execute the maintenance command
     *
     * @return void
     */
    public function fire()
    {
        $this->maintenance->up();
    }

    protected function getOn()
    {
        if ($on = $this->option('on')) {
            return Carbon::createFromFormat($this->option('format'), $on);
        }

        return null;
    }

    protected function getFinish()
    {
        if ($finish = $this->option('finish')) {
            return Carbon::createFromFormat($this->option('format'), $finish);
        }

        return null;
    }

    protected function getOptions()
    {
        return array(
            array('on', null, InputOption::VALUE_OPTIONAL, 'down application on time', null),
            array('finish', null, InputOption::VALUE_OPTIONAL, 'down application on time', null),
            array('format', null, InputOption::VALUE_OPTIONAL, 'times format', 'Y-m-d H:i:s'),
            array('message', null, InputOption::VALUE_OPTIONAL, 'down application message', null)
        );
    }
}
