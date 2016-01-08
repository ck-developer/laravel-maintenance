<?php

/*
 * This file is part of the LaravelMaintenance package.
 *
 * (c) Claude Khedhiri <claude@khedhiri.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ck\Laravel\Maintenance;

use Carbon\Carbon;
use Illuminate\Foundation\Application;

class Maintenance
{
    /**
     * @var \Illuminate\Foundation\Application;
     */
    private $app;

    /**
     * @var \Illuminate\Filesystem\Filesystem;
     */
    private $file;

    /**
     * @var array;
     */
    private $meta;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->file = $app['files'];

        $this->load();
    }

    public function down($downOn = "now", $message = null, $upOn = null)
    {
        $this->setDownOn($downOn)
            ->setDownMessage($message)
            ->setUpOn($upOn);

        $this->file->put($this->getPath(), json_encode($this->meta));
    }

    public function up()
    {
        if (!$this->file->exists($this->getPath())) {
            return false;
        }

        $this->file->delete($this->getPath());

        return true;
    }

    public function isDown()
    {
        if (!$this->file->exists($this->getPath())) {
            return false;
        }

        return true;
    }

    protected function load()
    {
        if ($this->file->exists($this->getPath())) {
            $this->meta = json_decode($this->file->get($this->getPath()), true);
        }
    }

    protected function getPath()
    {
        return $this->app->storagePath() . '/framework/maintenance.json';
    }

    public function getMeta($key)
    {
        if (!array_key_exists($key, $this->meta)) {
            return false;
        }

        return $this->meta[$key];
    }

    public function setMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }

    public function getDownOn($format = null)
    {
        if (!$this->isDown()) {
            return null;
        }

        if (!$format) {
            return Carbon::createFromTimestamp($this->getMeta('down_on'));
        }

        return Carbon::createFromTimestamp($this->getMeta('down_on'))->format($format);
    }

    public function setDownOn($time)
    {
        if ($time == 'now') {
            $this->meta['down_on'] = Carbon::now()->timestamp;
        } else {
            $this->meta['down_on'] = Carbon::createFromFormat('Y-m-d H:i:s', $time)->timestamp;
        }

        return $this;
    }

    public function setDownMessage($text)
    {
        $this->meta['down_message'] = $text;

        return $this;
    }

    public function setUpOn($time)
    {
        if ($time) {
            if ($time == 'now') {
                $this->meta['up_on'] = Carbon::now()->timestamp;
            } else {
                $this->meta['up_on'] = Carbon::createFromFormat('Y-m-d H:i:s', $time)->timestamp;
            }
        } else {
            $this->meta['up_on'] = null;
        }

        return $this;
    }

    public function getUpOn($format = null)
    {
        if (!$this->isDown()) {
            return null;
        }

        if (!$format) {
            return Carbon::createFromTimestamp($this->getMeta('up_on'));
        }

        return Carbon::createFromTimestamp($this->getMeta('up_on'))->format($format);
    }

    public function getDownMessage()
    {
        if (!$this->isDown()) {
            return null;
        }

        return $this->getMeta('down_message');
    }
}
