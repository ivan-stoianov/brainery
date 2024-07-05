<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Services\Contracts\FlashMessage;
use App\Services\Contracts\SeoMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        protected readonly SeoMeta $seoMeta,
        protected readonly FlashMessage $flashMessage
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

        $email = $request->string('email');
        $password = $request->string('password');

        $credentials = [
            'type' => UserType::ADMIN,
            'active' => true,
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $this->flashMessage->success(__('Success'));

            return redirect()->intended(route('admin.home'));
        } else {
            return redirect()
                ->route('admin.auth.login')
                ->withInput()
                ->withErrors([
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
