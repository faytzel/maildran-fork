<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Response;

class OpenMetricsController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $stats = [
            'users'     => repo('user')->countActivated(),
            'reminders' => repo('reminder')->countNotified(),
        ];

        return Response::html('openMetrics.index', compact('stats'));
    }
}
