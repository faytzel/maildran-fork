<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use File;

class HelperServiceProvider extends ServiceProvider
{
    protected $path = 'app/Helpers';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $files = File::files(base_path($this->path));
        foreach ($files as $file) {
            if (File::extension($file) == 'php') {
                require_once $file;
            }
        }
    }
}
