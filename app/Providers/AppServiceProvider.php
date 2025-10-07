<?php

namespace App\Providers;

use App\Http\Controllers\UserRoleController;
use App\Models\Inspection;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        \Gate::define('admin-access', function (User $user) {
            return $user->is_admin;
        });

        \Gate::define('super-admin', function (User $user) {
            return $user->is_admin && $user->is_super_admin;
        });

        \Gate::define('manage-users', function (User $user) {
            return (\Gate::allows('admin-access') || \Gate::allows('super-admin'));
        });


        Gate::define('delete-users', function (User $user, User $userReceived) {
            return Gate::allows('manage-users') && $userReceived->id != $user->id && !$userReceived->is_super_admin;
        });

        Gate::define('delete-super-admin', function (User $user, User $userReceived) {
            return Gate::allows('super-admin') && $userReceived->id != $user->id;
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading();


    }

}
