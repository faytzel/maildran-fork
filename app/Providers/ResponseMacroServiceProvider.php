<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;
use App;
use Stringy;

class ResponseMacroServiceProvider extends ServiceProvider
{
    protected $path                   = 'app/Extensions/Responses';

    protected $namespace              = 'App\Extensions\Responses';

    protected $responseMacroNameRegex = '/ResponseMacro$/';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerResponses();
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

    public function registerResponses() : void
    {
        // get class names
        $classNames = file_get_class_names(base_path($this->path));

        foreach ($classNames as $className) {
            // get name blade directive
            $responseMacroName = preg_replace($this->responseMacroNameRegex, '', Stringy::lowerCaseFirst($className));

            // get namespace
            $namespace = $this->namespace;

            // instance macro
            Response::macro($responseMacroName, function () use ($namespace, $className) {
                $responseMacroClass = $namespace . '\\' . $className;

                return call_user_func_array([
                    App::make($responseMacroClass),
                    'handle'
                ], func_get_args());
            });
        }
    }
}
