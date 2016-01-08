<?php

/*
 * This file is part of the LaravelMaintenance package.
 *
 * (c) Claude Khedhiri <claude@khedhiri.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ck\Laravel\Maintenance\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Ck\Laravel\Maintenance\Maintenance;
use Illuminate\Http\Response;

class CheckForMaintenance
{

    protected $app;

    protected $request;

    protected $response;

    protected $maintenance;

    public function __construct(Application $app, Request $request, Response $response, Maintenance $maintenance)
    {
        $this->app = $app;
        $this->request = $request;
        $this->response = $response;
        $this->maintenance = $maintenance;
    }

    public function handle($request, Closure $next)
    {
        if ($this->maintenance->isDown()) {
            if ($this->maintenance->getUpOn()->gt(Carbon::now())) {
                $this->maintenance->up();
            } else {
                return $this->response->create('down', 503);
            }
        }

        return $next($request);
    }
}
