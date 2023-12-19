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

        $this->createRequest('create');

        $this->createRequest('update');

        $this->createExport();

        $this->createImport();

        $this->createResource();

        $this->createResourceCollection();

        $this->createPolicy();

        $this->createTest();

        $this->createController();

        // $this->createView();

        // $this->createModal();

        // $this->createModule();

        $this->createLang();

        $this->replaceLines();
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
    protected function createRequest($type)
    {
        $request = Str::studly(class_basename($this->argument('name')));

        $method = $type === 'create' ? 'Store': 'Update';

        $this->call('component:request', [
            'name' => "{$request}{$method}Request",
            '--model' => $request,
            '--type' => $type,
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
     * Create a resource file for the model.
     *
     * @return void
     */
    protected function createResource()
    {
        $resource = Str::studly(class_basename($this->argument('name')));

        $this->call('component:resource', [
            'name' => "{$resource}Resource"
        ]);
    }

    /**
     * Create a resource collection file for the model.
     *
     * @return void
     */
    protected function createResourceCollection()
    {
        $resource = Str::studly(class_basename($this->argument('name')));

        $this->call('component:resource', [
            'name' => "{$resource}Collection"
        ]);
    }

    /**
     * Create a policy file for the model.
     *
     * @return void
     */
    protected function createPolicy()
    {
        $policy = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('component:policy', [
            'name' => "{$policy}Policy",
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

    /**
     * Create a lang file for the model.
     *
     * @return void
     */
    protected function createLang()
    {
        $model = Str::studly(class_basename($this->argument('name')));
        $file = Str::snake(class_basename($this->argument('name')));

        $this->call('component:lang', [
            'name' => "{$file}",
            '--model' => $model,
            '--lang' => 'es',
        ]);

        $this->call('component:lang', [
            'name' => "{$file}",
            '--model' => $model,
            '--lang' => 'en',
        ]);
    }

    /**
     * Replace lines of files.
     *
     * @return void
     */
    protected function replaceLines()
    {
        $module = Str::studly(class_basename($this->argument('name')));

        $this->call('replace:lines', [
            '--model' => $module,
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
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
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
