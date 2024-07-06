<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SeoMetaInterface;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function __construct(
        protected readonly SeoMetaInterface $seoMeta
    ) {
    }

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Users'));

        return view('admin.users.index');
    }
}