<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stringy;
use Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    protected $path = 'app/Extensions/Validators';

    protected $namespace = 'App\Extensions\Validators';

    protected $implicitRules = [
        //
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerValidators();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function registerValidators() : void
    {
        // get class names
        $classNames = file_get_class_names(base_path($this->path));

        // get rules and replacers
        $validations = $this->getRulesAndReplacers($this->namespace, $classNames);

        // register custom validatiors
        foreach ($validations['rules'] as $name => $classMethod) {
            // if rule es implicit
            if (in_array($name, $this->implicitRules)) {
                Validator::extendImplicit($name, $classMethod);
            // ese, normal rule
            } else {
                Validator::extend($name, $classMethod);
            }
        }

        // register replaces for custom validatiorts
        foreach ($validations['replacers'] as $name => $classMethod) {
            Validator::replacer($name, $classMethod);
        }
    }

    public function getRulesAndReplacers(string $namespace, array $classValidations) : array
    {
        $validations = [
            'rules'     => [],
            'replacers' => [],
        ];

        foreach ($classValidations as $className) {
            // get methods class
            $classMethods = get_class_methods($namespace . '\\' . $className);
            foreach ($classMethods as $methodName) {
                $isMethodValidate = starts_with($methodName, 'validate');
                $isMethodReplace  = starts_with($methodName, 'replace');

                if ($isMethodValidate || $isMethodReplace) {
                    // get name rule
                    $ruleName = preg_replace('/^(validate|replace)/', '', $methodName);
                    $ruleName = Stringy::underscored($ruleName);

                    // get class rule
                    $ruleClass = $namespace . '\\' . $className . '@' . $methodName;

                    if ($isMethodValidate) {
                        $validations['rules'][$ruleName] = $ruleClass;
                    } elseif ($isMethodReplace) {
                        $validations['replacers'][$ruleName] = $ruleClass;
                    }
                }
            }
        }

        return $validations;
    }
}
