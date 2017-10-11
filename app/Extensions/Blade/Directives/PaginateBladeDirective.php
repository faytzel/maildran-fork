<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class PaginateBladeDirective
{
    public function handle($expression) : string
    {
        return '<?php echo $expression->links(); ?>';
    }
}
