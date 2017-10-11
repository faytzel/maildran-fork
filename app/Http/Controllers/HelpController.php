<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Response;
use Auth;
use Illuminate\Http\Request as HttpRequest;

class HelpController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        return Response::html('help.index');
    }

    public function workflow()
    {
        return Response::html('help.workflow');
    }

    public function bookmark(HttpRequest $request)
    {
        $bookmark = null;

        if (Auth::check()) {
            $bookmark = 'javascript:window.location.href="mailto:' . $request->user()->email_reminder
                        . '?body="+encodeURIComponent(document.title+"\n"+window.location.href);';
        }

        return Response::html('help.bookmark', compact('bookmark'));
    }

    public function reminderNew()
    {
        return Response::html('help.reminderNew');
    }

    public function reminderDatetime()
    {
        return Response::html('help.reminderDatetime');
    }
}
