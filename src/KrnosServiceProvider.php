<?php

namespace Krnos\Laravel;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use Krnos\Laravel\Commands\ModelMakeCommand;

class KrnosServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('make.model', function () {
            $files = new Filesystem();
            return new ModelMakeCommand($files);
        });

        $this->commands('make.model');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
