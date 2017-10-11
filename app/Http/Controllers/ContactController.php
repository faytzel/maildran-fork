<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Mail;
use App\Mail\ContactMail;
use Config;
use Response;
use App\Http\Requests\Contact\CreateFormRequest;

class ContactController extends Controller
{
    public function __construct()
    {
        //
    }

    public function new()
    {
        return Response::html('contact.new');
    }

    public function create(CreateFormRequest $request)
    {
        Mail::to([[
                'email' => Config::get('mail.notify.address'),
                'name'  => Config::get('mail.notify.name'),
            ]])
            ->send(new ContactMail($request->all()));

        return Response::redirect('contact.success');
    }

    public function success()
    {
        return Response::html('contact.success');
    }
}
