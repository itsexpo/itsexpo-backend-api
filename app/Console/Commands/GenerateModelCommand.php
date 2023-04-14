<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateModelCommand extends Command
{
    protected $signature = 'expo:model {name : The name of the model}';

    protected $description = 'Generate eloquent and facade model';

    public function handle()
    {
        $name = $this->argument('name');
        $name = ucfirst($name);

        $facadeModelDirectory = app_path("Core/Domain/Models/{$name}");
        $facadeRepositoryDirectory = app_path("Infrastucture/Repository");
        $facadeRepositoryInterfaceDirectory = app_path("Core/Domain/Repository");

        if (!is_dir($facadeModelDirectory)) {
            mkdir($facadeModelDirectory, 0777, true);
        }

        if (!is_dir($facadeRepositoryDirectory)) {
            mkdir($facadeRepositoryDirectory, 0777, true);
        }

        if (!is_dir($facadeRepositoryInterfaceDirectory)) {
            mkdir($facadeRepositoryInterfaceDirectory, 0777, true);
        }

        // Create the facade model file
        $facadeStub = File::get(base_path('stubs/models/facade.stub'));
        $facadeStub = str_replace('{model_name}', $name, $facadeStub);
        $facadePath = "{$facadeModelDirectory}/{$name}.php";
        File::put($facadePath, $facadeStub);

        // Create the facade repository file
        $repositoryStub = File::get(base_path('stubs/models/repository.stub'));
        $repositoryStub = str_replace('{model_name}', $name, $repositoryStub);
        $repositoryPath = "{$facadeRepositoryDirectory}/Sql{$name}Repository.php";
        File::put($repositoryPath, $repositoryStub);

        // Create the facade repository interface file
        $repositoryInterfaceStub = File::get(base_path('stubs/models/interface.stub'));
        $repositoryInterfaceStub = str_replace('{model_name}', $name, $repositoryInterfaceStub);
        $repositoryInterfacePath = "{$facadeRepositoryInterfaceDirectory}/{$name}RepositoryInterface.php";
        File::put($repositoryInterfacePath, $repositoryInterfaceStub);

        $this->info('Models generated successfully.');
    }
}
