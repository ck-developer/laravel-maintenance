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
        Maintenance::down('now', 'test');
    }

    protected function getOptions()
    {
        return array(
            array('on', null, InputOption::VALUE_OPTIONAL, 'down application on time', null),
        );
    }
}
