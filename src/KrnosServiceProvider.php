<?php

namespace Krnos\Laravel;

use Illuminate\Support\ServiceProvider;
use Krnos\Laravel\Console\NewViewCommand;
use Krnos\Laravel\Console\LangMakeCommand;
use Krnos\Laravel\Console\ViewMakeCommand;
use Krnos\Laravel\Console\ModelMakeCommand;
use Krnos\Laravel\Console\ScopeMakeCommand;
use Krnos\Laravel\Console\DialogMakeCommand;
use Krnos\Laravel\Console\ExportMakeCommand;
use Krnos\Laravel\Console\ImportMakeCommand;
use Krnos\Laravel\Console\ModuleMakeCommand;
use Krnos\Laravel\Console\PolicyMakeCommand;
use Krnos\Laravel\Console\RequestMakeCommand;
use Krnos\Laravel\Console\ServiceMakeCommand;
use Krnos\Laravel\Console\NewComponentCommand;
use Krnos\Laravel\Console\ReplaceLinesCommand;
use Krnos\Laravel\Console\ResourceMakeCommand;
use Krnos\Laravel\Console\ControllerMakeCommand;
use Krnos\Laravel\Console\RepositoryMakeCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Krnos\Laravel\Console\ServiceInterfaceMakeCommand;
use Krnos\Laravel\Console\RepositoryInterfaceMakeCommand;

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
                PolicyMakeCommand::class,
                DialogMakeCommand::class,
                ModelMakeCommand::class,
                ModuleMakeCommand::class,
                LangMakeCommand::class,
                ServiceMakeCommand::class,
                ServiceInterfaceMakeCommand::class,
                RepositoryMakeCommand::class,
                RepositoryInterfaceMakeCommand::class,
                NewComponentCommand::class,
                NewViewCommand::class,
                RequestMakeCommand::class,
                ResourceMakeCommand::class,
                ViewMakeCommand::class,
                ReplaceLinesCommand::class,
                ScopeMakeCommand::class,
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
