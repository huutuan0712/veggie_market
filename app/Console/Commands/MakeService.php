<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $servicePath = app_path("Services/{$name}.php");

        if (File::exists($servicePath)) {
            $this->error('Service already exists!');
            return;
        }

        // Tạo thư mục nếu chưa tồn tại
        if (!File::exists(app_path('Services'))) {
            File::makeDirectory(app_path('Services'), 0755, true);
        }

        // Nội dung file service
        $stub = <<<PHP
<?php

namespace App\Services;

use App\Services\BaseService;

class {$name} extends BaseService
{
    // Viết phương thức xử lý tại đây
}

PHP;

        File::put($servicePath, $stub);
        $this->info("Service created: {$servicePath}");
    }
}
