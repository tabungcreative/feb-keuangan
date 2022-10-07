<?php

namespace App\Providers;

use App\Helper\AuthUser;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

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

        //
        Gate::define('super-admin', function ($user = null) {
            $user = AuthUser::user();

            return in_array('super-admin', $user->roles);
        });
        Gate::define('bendahara', function ($user = null) {
            $user = AuthUser::user();
            return in_array('bendahara', $user->roles);
        });
        Gate::define('dekan', function ($user = null) {
            $user = AuthUser::user();
            return in_array('dekan', $user->roles);
        });
        Gate::define('kabag-tu', function ($user = null) {
            $user = AuthUser::user();
            return in_array('kabag-tu', $user->roles);
        });
    }
}
