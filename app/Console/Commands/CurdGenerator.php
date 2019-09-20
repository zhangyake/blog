<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CurdGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curd:generator {name}';

    protected $description = 'Create CRUD operations';
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $name = ucfirst($name);
        $this->controller($name);
        $this->request($name);
        $this->model($name);
//        $this->repository($name);

        $this->makeResource($name);

        $nameLowerPlural = Str::plural(strtolower($name)); // 模型名称转复数形式 eg: Car => cars
        File::append(base_path('routes/api.php'), "\n// $name 相关接口\n");
        File::append(base_path('routes/api.php'), 'Route::get(\''.$nameLowerPlural."', 'Api\\".$name."Controller@index');\n");
        File::append(base_path('routes/api.php'), 'Route::post(\''.$nameLowerPlural."', 'Api\\".$name."Controller@store');\n");
        File::append(base_path('routes/api.php'), 'Route::get(\''.$nameLowerPlural."/{id}', 'Api\\".$name."Controller@show');\n");
        File::append(base_path('routes/api.php'), 'Route::put(\''.$nameLowerPlural."/{id}', 'Api\\".$name."Controller@update');\n");
        File::append(base_path('routes/api.php'), 'Route::delete(\''.$nameLowerPlural."/{id}', 'Api\\".$name."Controller@destroy');\n");
        $this->info('api-routes append successful');
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function model($name)
    {
        $modelTemplate = str_replace(['{{modelName}}'], [$name], $this->getStub('Model'));

        $modelPath = app_path("/Models/{$name}.php");
        if ($this->files->exists($modelPath)) {
            $this->error($modelPath.' 文件已存在');

            return;
        }
        file_put_contents($modelPath, $modelTemplate);
        $this->info($modelPath.' 已创建');
    }

    /**
     * 模型名称 eg Car.
     *
     * @param $name
     */
    protected function controller($name)
    {
        $controllerTemplate = str_replace([
            '{{modelName}}',
            '{{modelNamePluralLowerCase}}',
            '{{modelNameSingularLowerCase}}',
        ], [
                $name,
                lcfirst(Str::plural($name)),
                lcfirst($name),
            ], $this->getStub('Controller'));

        $controllerPath = app_path("/Http/Controllers/Api/{$name}Controller.php");

        if ($this->files->exists($controllerPath)) {
            $this->error($controllerPath.'文件已存在');

            return;
        }
        file_put_contents($controllerPath, $controllerTemplate);
        $this->info($controllerPath.' 已创建');
    }

    protected function request($name)
    {
        $requestTemplate = str_replace(['{{modelName}}'], [$name], $this->getStub('Request'));
        if (!file_exists($path = app_path('/Http/Requests'))) {
            mkdir($path, 0777, true);
        }

        $requestPath = app_path("/Http/Requests/{$name}Request.php");
        if ($this->files->exists($requestPath)) {
            $this->error($requestPath.' 文件已存在');

            return;
        }
        file_put_contents($requestPath, $requestTemplate);
        $this->info($requestPath.' 已创建');
    }

    protected function repository($name)
    {
        $repositoryTemplate = str_replace(['{{modelName}}', '{{modelNameSingularLowerCase}}'], [$name, lcfirst($name)],
        $this->getStub('Repository'));
        if (!file_exists($path = app_path('/Repositories'))) {
            mkdir($path, 0777, true);
        }

        $repositoryPath = app_path("/Repositories/{$name}Repository.php");

        if ($this->files->exists($repositoryPath)) {
            $this->error($repositoryPath.' 文件已存在');

            return;
        }
        file_put_contents($repositoryPath, $repositoryTemplate);
        $this->info($repositoryPath.' 已创建');
    }

    private function makeResource(string $name)
    {
        $resourcePath = app_path("/Http/Resources/{$name}/{$name}Resource.php");
        if ($this->files->exists($resourcePath)) {
            $this->error($resourcePath.' 文件已存在');

            return;
        }
        Artisan::call('make:resource', ['name' => $name.'/'.$name.'Resource']);
        $this->info($resourcePath.' 已创建');
    }
}
