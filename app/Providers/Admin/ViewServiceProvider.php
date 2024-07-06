<?php

declare(strict_types=1);

namespace App\Providers\Admin;

use App\View\Composers\AppSettingComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(
            ['admin.layouts.app'],
            AppSettingComposer::class
        );
    }
}
