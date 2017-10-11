<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class TextPrettyBladeDirective
{
    public function handle($expression) : string
    {
        return '<?php echo nl2br(string_to_link(' . $expression . ')); ?>';
    }
}
