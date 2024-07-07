<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SeoMetaServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected readonly SeoMetaServiceInterface $seoMeta
    ) {
    }

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Dashboard'));

        return view('admin.home');
    }

    public function toggleSidebar(): JsonResponse
    {
        if (Cookie::has('app_sidebar_hide')) {
            Cookie::queue(Cookie::forget('app_sidebar_hide'));

            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        return response()->json([], Response::HTTP_NO_CONTENT)->withCookie(
            cookie('app_sidebar_hide', 'true', 12 * 31 * 24 * 60)
        );
    }
}
