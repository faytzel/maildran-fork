<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class DateBladeDirective
{
    public function handle($expression) : string
    {
        return '<?php echo date_printable(' . $expression . '); ?>';
    }
}
