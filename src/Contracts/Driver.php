<?php

/*
 * This file is part of the Laravel Maintenance package.
 *
 * (c) Claude Khedhiri <khedhiri@madewithcaffeine.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mwc\Laravel\Maintenance\Contracts;

interface Driver
{
    /**
     * Retrieve an item from the Maintenance by key.
     *
     * @param  string|array  $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return void
     */
    public function put($key, $value);

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function forget($key);

    /**
     * Remove all items from the cache.
     *
     * @return void
     */
    public function flush();
}
