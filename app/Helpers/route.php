<?php

declare(strict_types=1);

function route_load(string $folder) : void
{
    $files = File::files(base_path('routes/' . $folder));
    foreach ($files as $file) {
        $className = '\Routes\\' . $folder . '\\' . File::name($file);
        $route = new $className();
        $route->handle();
    }
}
