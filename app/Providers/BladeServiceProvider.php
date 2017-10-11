<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use Stringy;
use App;

class BladeServiceProvider extends ServiceProvider
{
    protected $path                    = 'app/Extensions/Blade/Directives';

    protected $namespace               = 'App\Extensions\Blade\Directives';

    protected $bladeDirectiveNameRegex = '/_blade_directive$/';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBladeDirectives();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function registerBladeDirectives() : void
    {
        // get class names
        $classNames = file_get_class_names(base_path($this->path));

        foreach ($classNames as $className) {
            // get name blade directive
            $directiveName = preg_replace($this->bladeDirectiveNameRegex, '', Stringy::underscored($className));

            // instance blade directives
            Blade::directive($directiveName, function ($expression) use ($className) {
                $bladeDirectiveClass = $this->namespace . '\\' . $className;
                return App::make($bladeDirectiveClass)->handle($expression);
            });
        }
    }
}
