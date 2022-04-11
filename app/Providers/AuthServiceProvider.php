<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('manage-accounts', function ($user) {
            return $user->is_admin == true;
        });
        Gate::define('access-backup', function ($user) {
            return $user->is_admin == true;
        });
        Gate::define('create-accounts', function ($user) {
            return $user->is_admin == true;
        });
        Gate::define('delete-accounts', function ($user) {
            return $user->is_admin == true;
        });
        Gate::define('edit-accounts', function ($user) {
            return $user->is_admin == true;
        });
        Gate::define('resetpassword', function ($user) {
            return $user->is_admin == true;
        });
        Gate::define('edit-device', function ($user) {
            return $user->is_admin == true;
        });
        
        //
    }
}
