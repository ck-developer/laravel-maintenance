<?php

/*
 * This file is part of the LaravelMaintenance package.
 *
 * (c) Claude Khedhiri <claude@khedhiri.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ck\Laravel\Maintenance\Console\Commands;

use Illuminate\Foundation\Console\UpCommand as Command;
use Maintenance;

class UpCommand extends Command
{
    /**
     * Execute the maintenance mode command
     *
     * @return void
     */
    public function fire()
    {
        Maintenance::up();
    }
}
