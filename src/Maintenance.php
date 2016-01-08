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

    /**
     * Create the Maintenance instance
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->file = $app['files'];

        $this->load();
    }

    /**
     * Load meta from file
     * @return void
     */
    protected function load()
    {
        if ($this->file->exists($this->path())) {
            $this->meta = json_decode($this->file->get($this->path()), true);
        } else {
            $this->meta = array();
        }
    }

    /**
     * Get the path to the file to use
     * @return string
     */
    protected function path()
    {
        return $this->app->storagePath() . '/framework/maintenance.json';
    }

    /**
     * Get a value from meta
     * @param string $key
     * @return mixed
     */
    protected function get($key = null)
    {
        if (empty($key))
        {
            return $this->meta;
        }

        if($this->has($key))
        {
            return array_get($this->meta, $key);
        }
    }

    /**
     * Get a value in meta
     * @param $key string
     * @param  mixed $value
     * @return $this
     */
    protected function set($key, $value)
    {
        array_set($this->meta,$key,$value);

        return $this;
    }

    /**
     * Get a value in meta
     * @param $key string
     * @return $this
     */
    public function has($key)
    {
        if(array_key_exists($key, $this->meta))
        {
            return true;
        }

        return false;
    }

    /**
     * Save the file
     *
     * @return void
     */
    protected function save()
    {
        $this->file->put($this->path(), json_encode($this->meta));
    }

    /**
     * Delete the file
     *
     * @return void
     */
    protected function delete()
    {
        $this->file->delete($this->path());
    }

    public function getOn($format = null)
    {
        if($on = $this->get('on'))
        {
            Carbon::createFromTimestamp($on);

            if($format)
            {
                return $on->format($format);
            }

            return $on;
        }
    }

    public function getFinish($format = null)
    {
        if($finish = $this->get('finish'))
        {
            Carbon::createFromTimestamp($finish);

            if($format)
            {
                return $finish->format($format);
            }

            return $finish;
        }
    }

    public function on($time = 'now', $format = 'Y-m-d H:i:s')
    {
        if($time == 'now' || is_null($time))
        {
            $this->set('on', Carbon::now()->timestamp);

            return $this;
        }

        if($time instanceof Carbon)
        {
            $this->set('on', $time->timestamp);

        } else {
            $this->set('on', Carbon::createFromFormat($format, $time)->timestamp);
        }

        return $this;
    }

    public function finish($time = 'now', $format = 'Y-m-d H:i:s')
    {
        if(is_null($time))
        {
            return $this;
        }

        if($time == 'now')
        {
            $this->set('finish', Carbon::now()->timestamp);

            return $this;
        }

        if($time instanceof Carbon)
        {
            $this->set('finish', $time->timestamp);
        } else {
            $this->set('finish', Carbon::createFromFormat($format, $time)->timestamp);
        }

        return $this;
    }

    public function isDown()
    {
        if($this->has('on'))
        {
            return true;
        }

        return false;
    }

    public function down()
    {
        if(!$this->has('on'))
        {
            $this->on('now');
        }

        $this->save();
    }

    public function up()
    {
        $this->delete();
    }
}
