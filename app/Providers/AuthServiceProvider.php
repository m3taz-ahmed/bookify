<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Policies\BookingPolicy;
use App\Policies\ServicePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Service::class => ServicePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Filament Shield: Super Admin Gate - bypass all permission checks
        Gate::before(function ($user, $ability) {
            if ($user instanceof User) {
                return $user->hasRole('super_admin') ? true : null;
            }
            return null;
        });
    }
}