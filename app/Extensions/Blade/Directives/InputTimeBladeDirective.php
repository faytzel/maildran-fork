<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class InputTimeBladeDirective
{
    public function handle($expression) : string
    {
        return '<?php echo form_input_time(' . $expression . '); ?>';
    }
}
