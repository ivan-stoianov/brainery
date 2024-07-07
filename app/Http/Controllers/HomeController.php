<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Contracts\SeoMetaServiceInterface;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected readonly SeoMetaServiceInterface $seoMeta
    ) {}

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Home page'));

        return view('home');
    }
}
