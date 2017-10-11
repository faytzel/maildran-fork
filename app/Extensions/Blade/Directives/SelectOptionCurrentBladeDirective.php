<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class SelectOptionCurrentBladeDirective
{
    public function handle($expression) : string
    {
        $parameters = explode(',', $expression);
        $parameters = array_map('trim', $parameters);

        return '<?php if (' . $parameters[0] . ' === ' . $parameters[1] . ') echo "selected"; ?>';
    }
}
