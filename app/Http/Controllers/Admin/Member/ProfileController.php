<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Member;

use App\Exceptions\Admin\UserMemberNotFoundException;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserMemberInterface;
use App\Services\Contracts\SeoMetaInterface;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected readonly SeoMetaInterface $seoMeta,
        protected readonly UserMemberInterface $userMemberRepository
    ) {
    }

    public function show(int $memberId): View
    {
        $member = $this->userMemberRepository->findById($memberId);

        if (!$member) {
            throw new UserMemberNotFoundException();
        }

        $this->seoMeta->setTitle($member->getName());

        return view('admin.member.view', compact('member'));
    }
}
