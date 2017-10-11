<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    protected $policiesResources = [
        'reminder' => \App\Policies\ReminderPolicy::Class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPoliciesResources();
    }

    protected function registerPoliciesResources() : void
    {
        foreach ($this->policiesResources as $key => $policy) {
            Gate::resource($key, $policy, [
                'show'   => 'show',
                'new'    => 'create',
                'create' => 'create',
                'edit'   => 'update',
                'update' => 'update',
                'delete' => 'delete',
            ]);
        }
    }
}
