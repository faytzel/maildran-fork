<?php

declare(strict_types=1);

namespace App\Http\Middleware\Application;

use Closure;
use Config;
use Request;

class TrustedHostMiddleware
{
    protected const REGEX_DELIMITER = '#';

    public function handle($request, Closure $next)
    {
        // get domains and parsed
        $domains = collect(Config::get('app.domains'));
        $domainsParsed = $domains->map(function ($value, $key) {
            return $this->regexDomain($value);
        });

        // solo hosts verificados
        Request::setTrustedHosts($domainsParsed->values()->all());

        return $next($request);
    }

    protected function regexDomain(string $domain) : string
    {
        return '^' . preg_quote($domain, self::REGEX_DELIMITER) . '$';
    }
}
