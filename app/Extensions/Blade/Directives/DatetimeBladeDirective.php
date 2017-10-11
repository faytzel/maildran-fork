<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class DatetimeBladeDirective
{
    public function handle($expression) : string
    {
        return '<?php echo datetime_printable(' . $expression . '); ?>';
    }
}
