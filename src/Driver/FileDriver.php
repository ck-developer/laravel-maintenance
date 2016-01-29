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

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

class FileDriver extends Driver
{
    private $app;

    /**
     * @var Filesystem
     */
    private $file;

    private $path;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->file = $app['files'];
        $this->path = $app['config']['maintenance']['path'];

        parent::__construct();
    }

    public function load()
    {
        if ($this->file->exists($this->path())) {
            $this->items = json_decode($this->file->get($this->path()), true);
        }
    }

    public function store()
    {
        $this->file->put($this->path(), json_encode($this->all()));
    }

    public function path()
    {
        return $this->path . DIRECTORY_SEPARATOR . 'maintenance.json';
    }
}
