<?php

/*
 * This file is part of the Laravel Maintenance package.
 *
 * (c) Claude Khedhiri <claude@khedhiri.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ck\Laravel\Maintenance\Console\Commands;

use Carbon\Carbon;
use Illuminate\Foundation\Console\DownCommand as Command;
use Symfony\Component\Console\Input\InputOption;
use File;
use Maintenance;

class DownCommand extends Command
{
    /**
     * Execute the maintenance mode command
     *
     * @return void
     */
    public function fire()
    {
        Maintenance::on($this->getOn())->finish($this->getFinish())->down();
    }

    protected function getOn()
    {
        if($on = $this->option('on'))
        {
            return Carbon::createFromFormat($this->option('format'), $on);
        }

        return null;
    }

    protected function getFinish()
    {
        if($finish = $this->option('finish'))
        {
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
