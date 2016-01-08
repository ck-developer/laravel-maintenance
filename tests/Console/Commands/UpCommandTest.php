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
class UpCommandTest extends TestCase
{
    /**
     * Basic Test DownCommand.
     *
     * @test
     */
    public function testUpCommand()
    {
        $this->artisan('up');
    }
}
