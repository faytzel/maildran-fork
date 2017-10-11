<?php

declare(strict_types=1);

function url_is_app_domain(string $url) : bool
{
    // comprobamos el dominio con / al final para evitar que dominio como por ejemplo:
    // http://mydomain.fake.com sean validados
    $url = str_finish($url, '/');

    // obtenemos el dominio de la url (puede devolver string/null/false)
    $host = parse_url($url, PHP_URL_HOST);

    // comprobamos que la url tenga el mismo dominio que esta app
    if (!is_null($host) && $host !== false && $host === Config::get('app.domains.web')) {
        return true;
    }

    return false;
}
