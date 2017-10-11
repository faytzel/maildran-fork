<?php

declare(strict_types=1);

function string_collapse_whitespace(string $string) : string
{
    // todos los saltos de lineas a \n, ya que asi hacemos coincidir el contador de caracteres de JS con el de PHP
    // y evitamos que un salto de line consuma 2 caracteres
    $stringClean = preg_replace("/(\r\n|\n\r|\r){1}/", "\n", $string);

    // Elimina espacios duplicados
    $stringClean = Stringy::htmlEncode($stringClean);
    $stringClean = preg_replace('/(&nbsp;|[[:blank:]])+/', ' ', $stringClean);
    $stringClean = Stringy::htmlDecode($stringClean);

    // eliminar espacios al inicio y final del string
    $stringClean = trim($stringClean);

    return $stringClean;
}

function string_get_token(string $string = null) : string
{
    if (!is_null($string)) {
        $string .= '_';
    }

    return sha1(
        uniqid($string . '_' . str_random(mt_rand(20, 80)) . '_' . Request::ip() . '_' . microtime(true), true)
    );
}

function string_to_link(string $string) : string
{
    $spaceStart = '(\n|\s|^|\(|,|;|\.)';
    $protocol   = '(((((ht|f)tps?:\/\/){1}([A-Za-z0-9-.]+\.)?)|([A-Za-z0-9-\.]+\.))';
    $host       = '([0-9a-z-]+\.[0-9A-Za-z]{2,6})';
    $port       = '(:\d{1,})?';
    $path       = '(\/)?([^?<>\#\'\"\s,;\)]+)?';
    $query      = '(\?[^<>\#\"\s,\?\)]+)?'; // aqui no puedo filtrar por ";" porque los "&" llegan como "&amp;"
    $hash       = '(\#([^<>\#\"\s,\)]+)?)?)'; // aqui no puedo filtrar por ";" porque los "&" llegan como "&amp;"
    $spaceEnd   = '(?=\n|\s|\?|$|,|;|\))';

    return preg_replace_callback(
        '/' . $spaceStart . $protocol . $host . $port . $path  . $query . $hash . $spaceEnd . '/i',
        'string_to_link_callback',
        Stringy::htmlEncode($string)
    );
}

function string_to_link_callback(array $matches) : string
{
    $link      = $matches[2];
    $afterLink = '';

    // al no haber podido eliminar con la expresion regular el "." final de los enlaces, lo quito con php
    // es decir, de "http://example.php/index.html." solo cogera "http://example.php/index.html"
    if (Stringy::last($link, 1) == '.') {
        $link      = Stringy::substr($link, 0, Stringy::length($link) - 1);
        $afterLink = '.';
    }

    // añade https:// a las urls que no tienen para el href
    if (parse_url($link, PHP_URL_SCHEME) === null) {
        $linkHref = 'https://' . $link;
    } else {
        $linkHref = $link;
    }

    $string = $matches[1] . '<a href="' . $linkHref . '" title="" rel="nofollow">' . $link . '</a>' . $afterLink;

    return $string;
}
