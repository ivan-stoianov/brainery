<?php

namespace App\Http\Controllers\Admin\User;

use App\Exceptions\Admin\UserAdminNotFoundException;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserAdminRepositoryInterface;
use App\Services\Contracts\SeoMetaServiceInterface;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function __construct(
        protected readonly SeoMetaServiceInterface $seoMeta,
        protected readonly UserAdminRepositoryInterface $userAdminRepository
    ) {
    }

    public function index(int $userId): View
    {
        $user = $this->userAdminRepository->findById($userId);
        if (!$user) {
            throw new UserAdminNotFoundException();
        }

        $this->seoMeta->setTitle($user->getName());

        return view('admin.user.activity-log', compact('user'));
    }
}
