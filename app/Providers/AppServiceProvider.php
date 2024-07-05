<?php

namespace App\Providers;

use App\Services\HtmlExtendedService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Spatie\Html\Html;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\Contracts\SeoMeta::class, \App\Services\SeoMetaService::class);
        $this->app->bind('seo.meta.tools', \App\Services\SeoMetaService::class);

        $this->app->bind(\App\Services\Contracts\FlashMessage::class, \App\Services\FlashMessageService::class);
        $this->app->bind('flash.message', \App\Services\FlashMessageService::class);

        $this->app->singleton(Html::class, HtmlExtendedService::class);

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
        if (!App::isLocal()) {
            return;
        }

        if (class_exists(\Barryvdh\Debugbar\ServiceProvider::class)) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        if (class_exists(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class)) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
