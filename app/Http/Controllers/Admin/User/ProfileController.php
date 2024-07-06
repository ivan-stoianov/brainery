<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Exceptions\Admin\UserAdminNotFoundException;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserAdminInterface;
use App\Services\Contracts\SeoMetaInterface;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected readonly UserAdminInterface $userAdminRepository,
        protected readonly SeoMetaInterface $seoMeta
    ) {
    }

    public function show(int $userId): View
    {
        $user = $this->userAdminRepository->findById($userId);
        if (!$user) {
            throw new UserAdminNotFoundException();
        }

        $this->seoMeta->setTitle($user->getName());

        return view('admin.user.view', compact('user'));
    }
}
