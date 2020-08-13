<?php

namespace Krnos\Laravel;

use Krnos\Laravel\Console\ModelMakeCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class KrnosServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModelMakeCommand::class
            ]);
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->app->extend('command.make.model', function () {
                return new ModelMakeCommand;
            });
        }
    }

    /* Provides services.
     *
     * @return void
     */
    public function provides()
    {
        return [
            'command.make.model'
        ];
    }
}
