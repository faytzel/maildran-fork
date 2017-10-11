<?php

declare(strict_types=1);

function file_get_class_names(string $path) : array
{
    $classNames = [];

    $files = File::files($path);
    foreach ($files as $file) {
        if (File::extension($file) == 'php') {
            $classNames[] = File::name($file);
        }
    }

    return $classNames;
}
