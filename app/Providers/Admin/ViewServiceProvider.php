<?php

namespace App\Providers\Admin;

use App\View\Composers\AppSettingComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(
            ['admin.layouts.app'],
            AppSettingComposer::class
        );
    }
}
