<?php

/*
 * This file is part of the Laravel Maintenance package.
 *
 * (c) Claude Khedhiri <khedhiri@madewithcaffeine.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mwc\Laravel\Maintenance\Driver;

use Mwc\Laravel\Maintenance\Contracts\Driver as DriverContract;

abstract class Driver implements DriverContract
{
    protected $items = [];

    public function __construct()
    {
        $this->load();
    }

    abstract public function load();

    abstract public function store();

    /**
     * Retrieve all items from the Maintenance.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Retrieve an item from the Maintenance by key.
     *
     * @param  string|array $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return array_get($this->items, $key);
    }

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return $this
     */
    public function put($key, $value)
    {
        array_add($this->items, $key, $value);

        return $this;
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function forget($key)
    {
        array_forget($this->items, $key);

        return $this;
    }

    /**
     * Remove all items from the cache.
     *
     * @return $this
     */
    public function flush()
    {
        array_forget($this->items, array_keys($this->items));

        return $this;
    }
}
