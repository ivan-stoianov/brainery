<?php

namespace App\Providers;

use App\Services\HtmlExtendedService;
use Illuminate\Pagination\Paginator;
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

        $this->app->bind(\App\Repositories\Contracts\Member::class, \App\Repositories\MemberRepository::class);

        $this->registerLocalProviders();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        $this->registerCarbonMacros();
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

    protected function registerCarbonMacros(): void
    {
        \Illuminate\Support\Carbon::macro('toDateTimeHuman', function () {
            if (now()->subMinutes(10)->lessThan($this)) {
                return $this->diffForHumans();
            }

            if ($this->isToday()) {
                return $this->format('H:i');
            }

            if ($this->year === now()->year) {
                return $this->format('d M H:i');
            }

            return $this->format('d M Y H:i');
        });

        \Illuminate\Support\Carbon::macro('toDateHuman', function () {
            if (now()->subMinutes(10)->lessThan($this)) {
                return $this->diffForHumans();
            }

            if ($this->isToday()) {
                return $this->diffForHumans();
            }

            if ($this->year === now()->year) {
                return $this->format('d M');
            }

            return $this->format('d M Y');
        });
    }
}
