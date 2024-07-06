<?php

declare(strict_types=1);

use App\Exceptions\Admin\UserAdminNotFoundException;
use App\Exceptions\Admin\UserMemberNotFoundException;
use App\Facades\SeoMeta;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix(config('app.admin_prefix'))
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\Admin\Authenticate::class,
            'admin.guest' => \App\Http\Middleware\Admin\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (UserMemberNotFoundException $e, Request $request) {
            SeoMeta::setTitle(__('Member not found.'));

            return response()->view('admin.errors.member-not-found', [], Response::HTTP_NOT_FOUND);
        });
        $exceptions->render(function (UserAdminNotFoundException $e, Request $request) {
            SeoMeta::setTitle(__('User admin not found.'));

            return response()->view('admin.errors.user-not-found', [], Response::HTTP_NOT_FOUND);
        });
    })->create();
