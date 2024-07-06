<?php

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SeoMeta;
use Illuminate\View\View;

class MembersController extends Controller
{
    public function __construct(
        protected readonly SeoMeta $seoMeta,
    ) {
    }

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Members'));

        return view('admin.members.index');
    }
}
