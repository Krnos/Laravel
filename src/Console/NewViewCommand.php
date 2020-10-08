<?php

namespace Krnos\Laravel\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class NewViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:new {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view from model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createView();

        $this->createModal();

        $this->createModule();
    }

    /**
     * Create a view file for the model.
     *
     * @return void
     */
    protected function createView()
    {
        $view = Str::studly(class_basename($this->argument('name')));

        $this->call('component:view', [
            'name' => "{$view}",
            '--model' => $view,
        ]);
    }

    /**
     * Create a modal file for the model.
     *
     * @return void
     */
    protected function createModal()
    {
        $modal = Str::studly(class_basename($this->argument('name')));

        $this->call('component:modal', [
            'name' => "Modal{$modal}",
            '--model' => $modal,
        ]);
    }

    /**
     * Create a module file for the model.
     *
     * @return void
     */
    protected function createModule()
    {
        $module = Str::studly(class_basename($this->argument('name')));

        $this->call('component:module', [
            'name' => "{$module}",
            '--model' => $module,
        ]);
    }
}
