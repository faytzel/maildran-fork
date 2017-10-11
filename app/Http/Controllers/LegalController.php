<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Response;

class LegalController extends Controller
{
    public function __construct()
    {
        //
    }

    public function tos()
    {
        return Response::html('legal.tos');
    }

    public function privacy()
    {
        return Response::html('legal.privacy');
    }

    public function cookie()
    {
        return Response::html('legal.cookie');
    }
}
