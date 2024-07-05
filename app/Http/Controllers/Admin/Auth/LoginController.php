<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Contracts\FlashMessage;
use App\Services\Contracts\SeoMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $this->flashMessage->success(__('Success'));

        return redirect()->back();
    }
}
