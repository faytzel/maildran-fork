<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class DateAgoBladeDirective
{
    public function handle($expression) : string
    {
        return '<?php echo date_ago(' . $expression . '); ?>';
    }
}
