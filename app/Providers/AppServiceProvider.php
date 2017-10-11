<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Config;

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
        //
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
