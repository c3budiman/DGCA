<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CrudGenerator extends Command
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

  protected function view($name)
  {
      $viewTemplate = str_replace(
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
          $this->getStub('View2')
      );

      file_put_contents(base_path("/resources/views/auto/{$name}.blade.php"), $viewTemplate);
  }

  public function handle()
  {
      $name = $this->argument('name');

      $this->controller($name);
      $this->model($name);
      $this->request($name);
      $this->view($name);

      File::append(base_path('app/Http/routes.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');\n");
      File::append(base_path('app/Http/routes.php'), 'Route::get(\'' . strtolower($name) . "', '{$name}Controller@getFront');\n");
      File::append(base_path('app/Http/routes.php'), 'Route::get(\'' . strtolower($name) . "/json', '{$name}Controller@dataTB');\n");
      File::append(base_path('app/Http/routes.php'), 'Route::get(\'' . strtolower($name) . "/{method}', '{$name}Controller@viewSubmenu');\n\n");
      //Route::get('known-email/json', 'WebAdminController@knownEmailDataTB')->name('known-email/json');
  }
}
