<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Services\Contracts\FlashMessageInterface;
use App\Services\Contracts\SeoMetaInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        protected readonly SeoMetaInterface $seoMeta,
        protected readonly FlashMessageInterface $flashMessage
    ) {
    }

    public function show(): View
    {
        $this->seoMeta->setTitle(__('Authentication'));

        return view('admin.auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $rateLimiterKey = sprintf('admin.login:%s', $request->get('email'));
        $rateLimiterPerMinute = 5;

        if (RateLimiter::tooManyAttempts($rateLimiterKey, $rateLimiterPerMinute)) {
            $seconds = RateLimiter::availableIn($rateLimiterKey);

            return redirect()->back()->withInput()->withErrors([
                'email' => trans('auth.throttle', ['seconds' => $seconds]),
            ]);
        }

        $email = $request->string('email');
        $password = $request->string('password');

        $credentials = [
            'type' => UserType::ADMIN,
            'active' => true,
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            RateLimiter::clear($rateLimiterKey);

            $request->session()->regenerate();

            $this->flashMessage->success(__('Success'));

            return redirect()->intended(route('admin.home'));
        } else {
            RateLimiter::increment($rateLimiterKey);

            return redirect()->back()->withInput()->withErrors([
                'email' => trans('auth.failed'),
            ]);
        }

        return redirect()->back();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.auth.login');
    }
}
