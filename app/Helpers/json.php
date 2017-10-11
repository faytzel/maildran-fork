<?php

declare(strict_types=1);

function json_error(?stdClass $json) : bool
{
    if (is_null($json)) {
        return true;
    }

    return false;
}
