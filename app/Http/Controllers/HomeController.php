<?php

namespace App\Http\Controllers;

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
        $this->seoMeta->setTitle(__('Home page'));

        return view('home');
    }
}