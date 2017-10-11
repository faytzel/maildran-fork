<?php

declare(strict_types=1);

namespace App\Extensions\Responses;

use Illuminate\Http\JsonResponse;
use Response;
use Session;
use URL;
use Request;
use App\Exceptions\ResponseMacroException;

class FormResponseMacro
{
    protected const TYPES = [
        RESPONSE_FORM_REDIRECT,
        RESPONSE_FORM_RELOAD,
        RESPONSE_FORM_CLEAR
    ];

    public function handle(string $type = null, string $option = null) : JsonResponse
    {
        $redirect  = null;
        $reload    = false;
        $clearForm = false;
        $message   = null;

        // control method input data
        if (!is_null($type) && !in_array($type, self::TYPES)) {
            throw new ResponseMacroException('type nos valid');
        }
        if ($type === RESPONSE_FORM_REDIRECT && is_null($option)) {
            throw new ResponseMacroException('options should not null when is redirect');
        }
        if ($type !== RESPONSE_FORM_REDIRECT && !is_null($option)) {
            throw new ResponseMacroException('options should null when not is redirect');
        }

        // when is redirect
        if ($type === RESPONSE_FORM_REDIRECT) {
            $redirect = URL::route($option);
        // when is reload
        } elseif ($type === RESPONSE_FORM_RELOAD) {
            $reload = true;
        // in other case
        } else {
            // is input _back exists
            if (Request::has('_back')) {
                $urlBack = Request::get('_back');
                if (url_is_app_domain($urlBack)) {
                    $redirect = $urlBack;
                }
            } else {
                // when clear form
                if ($type === RESPONSE_FORM_CLEAR) {
                    $clearForm = true;
                }
            }
        }

        // when exists message
        if (Session::has('message')) {
            $message = Session::pull('message');
        }

        $json = [
            'reload'   => $reload,
            'clear'    => $clearForm,
            'redirect' => $redirect,
            'message'  => $message,
        ];

        return Response::json($json);
    }
}
