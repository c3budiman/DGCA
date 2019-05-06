<?php

namespace App\Commands;

use App\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class CrudGenerator extends Command implements SelfHandling
{

    protected $signature = 'crud:generator
    {name : Class (singular) for example User}';

    protected $description = 'Create CRUD operations';

    protected function getStub($type)
    {
        return file_get_contents(base_path("resources/stubs/$type.stub"));
    }

    protected function model($name)
    {
      $modelTemplate = str_replace(
          ['{{modelName}}'],
          [$name],
          $this->getStub('Model')
      );

      file_put_contents(app_path("/{$name}.php"), $modelTemplate);
    }

    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }

    protected function view($name)
    {

    }

    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        if(!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }

    public function handle()
    {
        $name = $this->argument('name');

        $this->controller($name);
        $this->model($name);
        $this->request($name);

        File::append(base_path('Http/app/routes.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');");
        if (strtolower($name) == 'home') {
          File::append(base_path('Http/app/routes.php'), 'Route::get(\'' . str_plural(strtolower($name)) . "', 'guestController@index');");
        } else {
          File::append(base_path('Http/app/routes.php'), 'Route::get(\'' . str_plural(strtolower($name)) . "', '{$name}Controller@getIndex');");
        }
    }
}
