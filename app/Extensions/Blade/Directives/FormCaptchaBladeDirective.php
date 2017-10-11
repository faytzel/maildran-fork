<?php

declare(strict_types=1);

namespace App\Extensions\Blade\Directives;

class FormCaptchaBladeDirective
{
    public function handle($expression) : string
    {
        // remove laterals commas
        $expression = preg_replace('/^\'/', '', $expression);
        $expression = preg_replace('/\'$/', '', $expression);

        $code = '<?php echo app(\'captcha\')->render(); ?>';
        $code .= '<script type="text/javascript">';
        $code .= 'window.onload = function() {};';
        $code .= '_submitForm = function() {';
        $code .= 'App.Form.sendForm($(\'#' . $expression . '\'));';
        $code .= '};';
        $code .= '</script>';

        return $code;
    }
}
