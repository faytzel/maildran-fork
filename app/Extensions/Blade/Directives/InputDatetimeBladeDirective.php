<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class InputDatetimeBladeDirective
{
    public function handle($expression) : string
    {
        return '<?php echo form_input_datetime(' . $expression . '); ?>';
    }
}
