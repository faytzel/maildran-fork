<?php

declare(strict_types=1);

namespace Routes\Web;

use Route;
use App;
use Response;

class TestRoute
{
    public function handle()
    {
        if (App::runningUnitTests() || App::isLocal()) {
            Route::prefix('test')
                ->group(function () {
                    // test json
                    Route::get('example.json', function () {
                        return Response::json(['a' => 1]);
                    })->name('test.json');

                    // xml json
                    Route::get('example.xml', function () {
                        return Response::make('<test><example>a</example></test>')
                            ->header('Content-Type', 'text/xml');
                    })->name('test.xml');
                });
        }
    }
}
