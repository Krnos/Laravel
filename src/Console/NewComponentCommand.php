<?php

namespace Krnos\Laravel\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class NewComponentCommand extends GeneratorCommand
{
   /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'component:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new component from model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false) {
            return false;
        }

        $this->createFactory();

        $this->createMigration();

        $this->createSeeder();

        $this->createRequest();

        $this->createExport();

        $this->createImport();

        $this->createTest();

        $this->createController();
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createFactory()
    {
        $factory = Str::studly(class_basename($this->argument('name')));

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a seeder file for the model.
     *
     * @return void
     */
    protected function createSeeder()
    {
        $seeder = Str::studly(class_basename($this->argument('name')));

        $this->call('make:seed', [
            'name' => "{$seeder}Seeder",
        ]);
    }

    /**
     * Create a request file for the model.
     *
     * @return void
     */
    protected function createRequest()
    {
        $request = Str::studly(class_basename($this->argument('name')));

        $this->call('component:request', [
            'name' => "{$request}Request",
            '--model' => $request,
        ]);
    }

    /**
     * Create a export file for the model.
     *
     * @return void
     */
    protected function createExport()
    {
        $export = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('component:export', [
            'name' => "{$export}Export",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a import file for the model.
     *
     * @return void
     */
    protected function createImport()
    {
        $import = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('component:import', [
            'name' => "{$import}Import",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('component:controller', [
            'name'  => "{$controller}Controller",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a test file for the model.
     *
     * @return void
     */
    protected function createTest()
    {
        $test = Str::studly(class_basename($this->argument('name')));

        $this->call('make:test', [
            'name' => "{$test}ControllerTest",
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/model.stub';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
