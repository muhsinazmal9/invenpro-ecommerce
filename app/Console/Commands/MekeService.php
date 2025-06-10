<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MekeService extends Command
{
    protected $signature = 'make:service {name : The name of the service}';

    protected $description = 'Create a new service';

    public function handle()
    {
        $name = $this->argument('name');
        $serviceClassName = $name.'Service';
        $serviceFileName = app_path("Services/{$serviceClassName}.php");

        if (file_exists($serviceFileName)) {
            $this->error("The service {$serviceClassName} already exists!");

            return 1;
        }

        $stub = file_get_contents(base_path('stubs/service.stub'));
        $stub = str_replace('{{serviceClassName}}', $serviceClassName, $stub);

        if (! is_dir(app_path('Services'))) {
            mkdir(app_path('Services'));
        }

        file_put_contents($serviceFileName, $stub);

        $this->info("Service {$serviceClassName} created successfully!");
    }
}
