<?php

namespace Krnos\Laravel\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ResourceMakeCommand extends GeneratorCommand
{
    use WithModelStub;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'component:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form resource class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->collection()) {
            $this->type = 'Resource collection';
        }

        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->collection()
                    ? $this->resolveStubPath('/../stubs/resource-collection.stub')
                    : $this->resolveStubPath('/../stubs/resource.stub');
    }

    /**
     * Determine if the command is generating a resource collection.
     *
     * @return bool
     */
    protected function collection()
    {
        return $this->option('collection') ||
               str_ends_with($this->argument('name'), 'Collection');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Resources\\' . $this->option('model');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the resource already exists'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource for the given model.'],
            ['collection', 'c', InputOption::VALUE_NONE, 'Create a resource collection'],
        ];
    }

}
