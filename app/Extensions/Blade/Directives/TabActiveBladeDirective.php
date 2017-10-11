<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class TabActiveBladeDirective
{
    public function handle($expression) : string
    {
        return '<?php if (Route::currentRouteNamed(' . $expression . ')) echo "active"; ?>';
    }
}
