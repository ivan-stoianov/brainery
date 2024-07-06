<?php

namespace App\Http\Controllers\Admin\Member;

use App\Exceptions\MemberNotFoundException;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\MemberInterface;
use App\Services\Contracts\SeoMetaInterface;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected readonly SeoMetaInterface $seoMeta,
        protected readonly MemberInterface $memberRepository
    ) {
    }

    public function show(int $memberId): View
    {
        $member = $this->memberRepository->findById($memberId);

        if (!$member) {
            throw new MemberNotFoundException();
        }

        $this->seoMeta->setTitle($member->getName());

        return view('admin.member.view', compact('member'));
    }
}
