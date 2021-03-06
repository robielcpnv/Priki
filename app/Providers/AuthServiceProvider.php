<?php

namespace App\Providers;

use App\Models\Practice;
use App\Models\User;
use App\Policies\PraticePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Practice::class => PraticePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-moderator', function () {
            return auth()->user()->role->slug === 'MOD';
        });
        Gate::define('update', function (?User $user, $practice) {
            return ($user->role->slug === 'MOD' && $practice->publicationState->slug === 'PRO');
        });
        Gate::define('published', function (?User $user, $practice) {
            return $practice->publicationState->slug === 'PUB' || ($user && $user->role->slug === 'MOD');
        });

    }
}
