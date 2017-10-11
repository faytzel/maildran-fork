<?php

declare(strict_types=1);

namespace Routes\Web;

use Route;
use RouteGenerator;

class OpenMetricsRoute
{
    public function handle()
    {
        RouteGenerator::resource('open-metrics', 'OpenMetricsController', [
            'index',
        ]);
    }
}
