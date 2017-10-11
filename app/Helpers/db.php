<?php

declare(strict_types=1);

function db_escape(string $string) : string
{
    return DB::getPdo()->quote($string);
}

/*
 * IMPORTANTE: No introducir el valor generado por esta funcion en un DB::raw()
 */
function db_escape_like(string $string) : string
{
    // Escapa \ (hay que hacer 3 escapes de \ y el cuarto escape se realiza en la contruccion de where)
    // Ver http://dev.mysql.com/doc/refman/5.0/es/string-comparison-functions.html
    $stringEscaped = str_replace('\\', '\\\\\\', $string);

    // Escapa caracteres de expresiones regulares
    $stringEscaped = str_replace(['_', '%'], ['\_', '\%'], $stringEscaped);

    return $stringEscaped;
}
