<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Hotel;
use App\Policies\HotelPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider {
    /**
     * Register services.
     */
    public function register(): void {
        //
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void {
        Gate::before(function ($user, $ability) {
            if (method_exists($user, 'isMega') && $user->isMega()) return true;
            if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) return true;
            return null;
        });

    }
}







