<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SeoMeta;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected readonly SeoMeta $seoMeta
    ) {
    }

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Dashboard'));

        return view('admin.home');
    }
}
