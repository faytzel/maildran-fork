<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Route;
use File;
use Config;
use App\Models\ReminderModel;
use App\Models\UserModel;
use Illuminate\Routing\Route as Router;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $patterns = [
        'reminder'        => '[0-9]+',
        'user'            => '[0-9]+',
        'userForCalendar' => '[0-9]+',
        'code'            => '[A-Za-z0-9]+',
    ];

    protected $models = [
        'reminder' => ReminderModel::class,
        'user'     => UserModel::class,
        // 'userForCalendar' => Closure
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPatterns();
        $this->registerModelBindings();

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes() : void
    {
        Route::domain(Config::get('app.domains.web'))
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(function () {
                route_load('Web');
            });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes() : void
    {
        Route::domain(Config::get('app.domains.api'))
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(function () {
                route_load('Api');
            });
    }

    protected function registerPatterns() : void
    {
        foreach ($this->patterns as $key => $pattern) {
            Route::pattern($key, $pattern);
        }
    }

    protected function registerModelBindings() : void
    {
        foreach ($this->models as $key => $model) {
            Route::model($key, $model);
        }

        Route::bind('userForCalendar', function (int $id, Router $route) {
            $user = repo('user')->findByIdAndCalendarToken($id, $route->token);
            if (c_one($user)) {
                return $user;
            }

            $exception = new ModelNotFoundException();
            $exception->setModel(UserModel::class);
            throw new $exception;
        });
    }
}
