<?php

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Member;
use App\Services\Contracts\SeoMeta;
use Illuminate\View\View;

class MembersController extends Controller
{
    public function __construct(
        protected readonly SeoMeta $seoMeta,
        protected readonly Member $memberRepository
    ) {
    }

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Members'));

        $members = $this->memberRepository->getPaginated();

        return view('admin.members.index', compact('members'));
    }
}
