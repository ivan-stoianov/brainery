<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerLocalProviders();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    protected function registerLocalProviders(): void
    {
        if (!App::environment('local')) {
            return;
        }

        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
    }
}
