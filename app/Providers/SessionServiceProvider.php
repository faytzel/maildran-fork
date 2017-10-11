<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Session;
use Config;
use DB;
use App\Extensions\Session\DatabaseSessionExtension;

class SessionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerSessionDriver();
    }

    public function register()
    {
        //
    }

    protected function registerSessionDriver() : void
    {
        Session::extend('database-extension', function ($app) {
            $connection = DB::connection(Config::get('session.connection'));
            $table      = Config::get('session.table');
            $lifetime   = Config::get('session.lifetime');

            return new DatabaseSessionExtension($connection, $table, $lifetime, $app);
        });
    }
}
