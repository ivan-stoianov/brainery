<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Policies\Admin\User\UserAdminPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(User::class, UserAdminPolicy::class);
    }
}
