<?php

/*
 * This file is part of the LaravelMaintenance package.
 *
 * (c) Claude Khedhiri <claude@khedhiri.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ck\Laravel\Maintenance\Test\Console\Commands;

use Ck\Laravel\Maintenance\Test\TestCase;

/**
 * Class DownCommandTest
 */
class DownCommandTest extends TestCase
{
    /**
     * Basic Test DownCommand.
     *
     * @test
     */
    public function testDown()
    {
        $this->artisan('down');
    }

    /**
     * Basic Test DownCommand.
     *
     * @test
     */
    public function testDownOn()
    {
        $this->artisan('down', array('--on' => '2016-01-07 00:00:00'));
    }
}
