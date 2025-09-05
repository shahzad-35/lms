<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\\Models\\Model' => 'App\\Policies\\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('is-instructor', function (User $user) {
            return $user->role === 'instructor';
        });

        Gate::define('is-student', function (User $user) {
            return $user->role === 'student';
        });

        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}