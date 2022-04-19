<?php

namespace Krnos\Laravel;

use Krnos\Laravel\Console\ControllerMakeCommand;
use Krnos\Laravel\Console\ExportMakeCommand;
use Krnos\Laravel\Console\ImportMakeCommand;
use Krnos\Laravel\Console\DialogMakeCommand;
use Krnos\Laravel\Console\ModelMakeCommand;
use Krnos\Laravel\Console\ModuleMakeCommand;
use Krnos\Laravel\Console\LangMakeCommand;
use Krnos\Laravel\Console\NewComponentCommand;
use Krnos\Laravel\Console\NewViewCommand;
use Krnos\Laravel\Console\RequestMakeCommand;
use Krnos\Laravel\Console\ViewMakeCommand;
use Krnos\Laravel\Console\ReplaceLinesCommand;
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
                ControllerMakeCommand::class,
                ExportMakeCommand::class,
                ImportMakeCommand::class,
                DialogMakeCommand::class,
                ModelMakeCommand::class,
                ModuleMakeCommand::class,
                LangMakeCommand::class,
                NewComponentCommand::class,
                NewViewCommand::class,
                RequestMakeCommand::class,
                ViewMakeCommand::class,
                ReplaceLinesCommand::class,
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
