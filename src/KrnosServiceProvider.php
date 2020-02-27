<?php

namespace Krnos\Laravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

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
            return new Commands\ModelMakeCommand;
        });

        $this->commands(
            'make.model'
        );
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/fire.php', 'fire');
    }
}
