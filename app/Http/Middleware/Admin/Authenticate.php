<?php

declare(strict_types=1);

namespace App\Http\Middleware\Admin;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('admin.auth.login');
    }
}
