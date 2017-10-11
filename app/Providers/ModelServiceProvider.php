<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class ModelServiceProvider extends ServiceProvider
{
    protected $path = 'app/Repositories';

    protected $namespaceRepositoryContract = 'App\Contracts\Repositories';
    protected $namespaceRepository = 'App\Repositories';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRepositories();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function registerRepositories() : void
    {
        // get class names
        $classNames = file_get_class_names(base_path($this->path));

        // register custom validatiors
        foreach ($classNames as $className) {
            $repositoryContract  = $this->namespaceRepositoryContract . '\\' . $className . 'Contract';
            $repository = $this->namespaceRepository . '\\' . $className;

            App::singleton($repositoryContract, $repository);
        }
    }
}
