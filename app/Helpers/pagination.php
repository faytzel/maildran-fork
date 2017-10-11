<?php

declare(strict_types=1);

function pagination_valid_page() : bool
{
    if (Request::has('page')) {
        $page = Request::input('page');

        // evita que el parametro GET sea array, estilo foo[]=bar
        if (!is_null($page)) {
            $isValidPage = preg_match('/^[0-9]+$/', (string) $page);
            if ($isValidPage && $page > 1) {
                return true;
            }
        }
    }

    return false;
}
