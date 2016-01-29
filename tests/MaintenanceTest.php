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

/**
 * Class MaintenanceTest
 */
class MaintenanceTest extends TestCase
{
    /**
     * @var \Mwc\Laravel\Maintenance\Maintenance;
     */
    protected $maintenance;

    public function setUp()
    {
        parent::setUp();

        $this->maintenance = $this->app['maintenance'];
    }

    /**
     * Basic Test Maintenance Up.
     *
     * @test
     */
    public function testMaintenanceUp()
    {
        $this->maintenance->up();
        $this->assertTrue($this->maintenance->isUp());
    }
}
