<?php

/*
 * This file is part of the Laravel Maintenance package.
 *
 * (c) Claude Khedhiri <khedhiri@madewithcaffeine.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mwc\Laravel\Maintenance\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mwc\Laravel\Maintenance\Maintenance;
use Illuminate\Http\Response;

class CheckForMaintenance
{
    protected $request;

    protected $response;

    protected $maintenance;

    public function __construct(Request $request, Response $response, Maintenance $maintenance)
    {
        $this->request = $request;
        $this->response = $response;
        $this->maintenance = $maintenance;
    }

    public function handle($request, Closure $next)
    {
        if ($this->maintenance->isDown()) {
            return $this->response->create('down', 503);
        }

        return $next($request);
    }
}
