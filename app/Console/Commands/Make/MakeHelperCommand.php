<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;

class MakeHelperCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {name}';

    protected $name = 'Make Helper Class';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Helper class';

    protected $type = 'Helper';

    
    protected function getStub()
    {
        return base_path('stubs/helper.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Helpers';
    }
}
