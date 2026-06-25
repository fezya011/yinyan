<?php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use App\Models\Admin;
use App\Policies\AdminPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Admin::class => AdminPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Gate для админов (используем существующий подход)
        Gate::define('admin', function (Admin $admin) {
            return $admin->is_active;
        });

        Gate::define('manage-categories', function (Admin $admin) {
            return $admin->is_active;
        });

        Gate::define('manage-products', function (Admin $admin) {
            return $admin->is_active;
        });

        Gate::define('manage-leads', function (Admin $admin) {
            return $admin->is_active;
        });

        Gate::define('view-logs', function (Admin $admin) {
            return $admin->is_active;
        });
    }
}
