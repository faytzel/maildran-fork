<?php

declare(strict_types=1);

namespace App\Extensions\Responses;

use Illuminate\Http\Response as HttpResponse;
use Response;

class AttachmentResponseMacro
{
    public function handle(string $content, string $filename, string $type) : HttpResponse
    {
        $headers = [
            'Content-type'        => $type,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return Response::make($content, 200, $headers);
    }
}
