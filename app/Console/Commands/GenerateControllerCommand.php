<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateControllerCommand extends Command
{
    protected $signature = 'expo:controller {name : The name of the controller}';

    protected $description = 'Generate a controller';

    public function handle()
    {
        $name = $this->argument('name');
        $name = ucfirst($name);

        $controllerDirectory = app_path("Http/Controllers");

        if (!is_dir($controllerDirectory)) {
            mkdir($controllerDirectory, 0777, true);
        }

        // Create the controller file
        $controllerStub = File::get(base_path('stubs/controllers/controller.stub'));
        $controllerStub = str_replace('{controller_name}', $name, $controllerStub);
        $controllerPath = "{$controllerDirectory}/{$name}Controller.php";
        File::put($controllerPath, $controllerStub);

        $this->info('Controller generated successfully.');
    }
}
