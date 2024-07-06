<?php

namespace App\Http\Controllers;

use App\Services\Contracts\SeoMetaInterface;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected readonly SeoMetaInterface $seoMeta
    ) {
    }

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Home page'));

        return view('home');
    }
}
