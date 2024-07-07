<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Repositories\Contracts\UserAdminRepositoryInterface;
use App\Repositories\Contracts\UserMemberRepositoryInterface;
use App\Repositories\SettingRepository;
use App\Repositories\UserAdminRepository;
use App\Repositories\UserMemberRepository;
use App\Services\ActivityLogService;
use App\Services\Contracts\ActivityLogServiceInterface;
use App\Services\Contracts\FlashMessageServiceInterface;
use App\Services\Contracts\SeoMetaServiceInterface;
use App\Services\Contracts\SettingServiceInterface;
use App\Services\Contracts\UserAdminServiceInterface;
use App\Services\FlashMessageService;
use App\Services\HtmlExtendedService;
use App\Services\SeoMetaService;
use App\Services\SettingService;
use App\Services\UserAdminService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Spatie\Html\Html;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SeoMetaServiceInterface::class, SeoMetaService::class);
        $this->app->bind('seo.meta.tools', SeoMetaService::class);

        $this->app->bind(FlashMessageServiceInterface::class, FlashMessageService::class);
        $this->app->bind('flash.message', FlashMessageService::class);

        $this->app->singleton(Html::class, HtmlExtendedService::class);

        // Repositories
        $this->app->bind(UserAdminRepositoryInterface::class, UserAdminRepository::class);
        $this->app->bind(UserMemberRepositoryInterface::class, UserMemberRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);

        // Services
        $this->app->bind(ActivityLogServiceInterface::class, ActivityLogService::class);
        $this->app->bind(SettingServiceInterface::class, SettingService::class);
        $this->app->bind(UserAdminServiceInterface::class, UserAdminService::class);

        $this->registerLocalProviders();
    }

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
