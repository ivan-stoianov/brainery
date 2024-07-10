<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Exceptions\Admin\UserAdminNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Contracts\SeoMetaServiceInterface;
use App\Services\Contracts\UserAdminServiceInterface;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function __construct(
        protected readonly SeoMetaServiceInterface $seoMetaService,
        protected readonly UserAdminServiceInterface $userAdminService
    ) {
    }

    public function index(int $userId): View
    {
        $user = $this->userAdminService->findById($userId);
        if (!$user) {
            throw new UserAdminNotFoundException();
        }

        $this->seoMetaService->setTitle($user->getName());

        return view('admin.user.activity-log', compact('user'));
    }
}
