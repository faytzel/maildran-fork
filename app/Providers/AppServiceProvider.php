<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Config;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    protected $constants = [
        'RESPONSE_FORM_REDIRECT' => 'redirect',
        'RESPONSE_FORM_RELOAD'   => 'reload',
        'RESPONSE_FORM_CLEAR'    => 'clear',
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Comment the next line code if use MySQL v5.7.7 and higher
        // https://laravel-news.com/laravel-5-4-key-too-long-error
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // set constants
        foreach ($this->constants as $constantName => $constantValue) {
            if (!defined($constantName)) {
                define($constantName, $constantValue);
            }
        }

        // set dev providers
        if (App::isLocal()) {
            $providers = Config::get('app.providersDev');
            foreach ($providers as $provider) {
                $this->app->register($provider);
            }
        }
    }
}
