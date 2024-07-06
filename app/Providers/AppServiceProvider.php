<?php

namespace App\Providers;

use App\Repositories\Contracts\MemberInterface;
use App\Repositories\Contracts\SettingInterface;
use App\Repositories\MemberRepository;
use App\Repositories\SettingRepository;
use App\Services\Contracts\FlashMessageInterface;
use App\Services\Contracts\SeoMetaInterface;
use App\Services\FlashMessageService;
use App\Services\HtmlExtendedService;
use App\Services\SeoMetaService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
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
        $this->app->bind(SeoMetaInterface::class, SeoMetaService::class);
        $this->app->bind('seo.meta.tools', SeoMetaService::class);

        $this->app->bind(FlashMessageInterface::class, FlashMessageService::class);
        $this->app->bind('flash.message', FlashMessageService::class);

        $this->app->singleton(Html::class, HtmlExtendedService::class);

        $this->app->bind(MemberInterface::class, MemberRepository::class);
        $this->app->bind(SettingInterface::class, SettingRepository::class);

        $this->registerLocalProviders();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Request::macro('isAdmin', function () {
            return $this->segment(1) === trim(config('app.admin_prefix'), '/');
        });

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
        Carbon::macro('toDateTimeHuman', function () {
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

        Carbon::macro('toDateHuman', function () {
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
