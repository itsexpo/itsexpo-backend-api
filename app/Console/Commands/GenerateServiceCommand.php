<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateServiceCommand extends Command
{
    protected $signature = 'expo:service {name : The name of the service}';

    protected $description = 'Generate a new service';

    public function handle()
    {
        $name = $this->argument('name');
        $name = ucfirst($name);

        $serviceDirectory = app_path("Core/Application/Service/{$name}");

        if (!is_dir($serviceDirectory)) {
            mkdir($serviceDirectory, 0777, true);
        }

        // Create the Service file
        $serviceStub = File::get(base_path('stubs/services/service.stub'));
        $serviceStub = str_replace('{service_name}', $name, $serviceStub);
        $servicePath = "{$serviceDirectory}/{$name}Service.php";

        File::put($servicePath, $serviceStub);

        // Create the Request file
        $requestStub = File::get(base_path('stubs/services/request.stub'));
        $requestStub = str_replace('{service_name}', $name, $requestStub);
        $requestPath = "{$serviceDirectory}/{$name}Request.php";
        File::put($requestPath, $requestStub);

        // Create the Response file
        $responseStub = File::get(base_path('stubs/services/response.stub'));
        $responseStub = str_replace('{service_name}', $name, $responseStub);
        $responsePath = "{$serviceDirectory}/{$name}Response.php";
        File::put($responsePath, $responseStub);

        $this->info('Service generated successfully.');
    }
}
