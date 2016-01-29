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

use Illuminate\Config\Repository as Config;
use Mwc\Laravel\Maintenance\Driver\Driver;

class Maintenance
{
    private $config;

    private $driver;

    /**
     * Create the Maintenance instance.
     *
     * @param Config $config
     * @param Driver $driver
     */
    public function __construct(Config $config, Driver $driver)
    {
        $this->config = $config;
        $this->driver = $driver;
    }

    public function up($message = null)
    {
        $this->setMessage($message);
        $this->driver->store();
    }

    public function setMessage($message = null)
    {
        if (is_null($message)) {
            $message = $this->config->get('maintenance.message');
        }

        $this->driver->put('message', 'maintenance.message');

        return $this;
    }

    public function isUp()
    {
        if($this->driver->get('message'))
        {
            return true;
        }
    }
}
