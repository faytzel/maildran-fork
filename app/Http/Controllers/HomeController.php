<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Response;

class HomeController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        return Response::html('home.index');
    }
}
