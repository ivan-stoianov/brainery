<?php

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SeoMetaInterface;
use Illuminate\View\View;

class MembersController extends Controller
{
    public function __construct(
        protected readonly SeoMetaInterface $seoMeta,
    ) {
    }

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Members'));

        return view('admin.members.index');
    }
}
