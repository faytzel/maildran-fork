<?php

declare(strict_types=1);

/**
 * Alias de is_natural_no_zero()
 */
function is_id(int $number) : bool
{
    return is_natural_no_zero($number);
}

/**
 * Comprueba si es numero y si este es mayor o igual a cero
 */
function is_natural(int $number) : bool
{
    if (preg_match('/^[0-9]+$/i', (string) $number) && $number >= 0) {
        return true;
    }

    return false;
}

/**
 * Comprueba si es numero y si este es mayor a cero
 */
function is_natural_no_zero(int $number) : bool
{
    if (preg_match('/^[0-9]+$/i', (string) $number) && $number > 0) {
        return true;
    }

    return false;
}
