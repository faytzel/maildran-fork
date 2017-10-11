<?php

declare(strict_types=1);

namespace App\Extensions\Responses;

use Illuminate\Http\Response as HttpResponse;
use View;
use Response;
use HTMLMin;
use App\Exceptions\ResponseMacroException;

class HtmlResponseMacro
{
    public function handle(string $name, array $params = []) : HttpResponse
    {
        if (array_key_exists('exception', $params)) {
            throw new ResponseMacroException('Cannot set param $exception');
        }

        // default value
        // used in Illuminate\Foundation\Exceptions\Handler@renderHttpException
        $params['exception'] = null;

        // get html
        $html = View::make($name, $params)->render();

        // minify html
        $html = HTMLMin::html($html);

        // response
        $response = Response::make($html);

        return $response;
    }
}
