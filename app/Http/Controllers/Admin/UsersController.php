<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\CreateUserAdminData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\CreateUserRequest;
use App\Services\Contracts\FlashMessageServiceInterface;
use App\Services\Contracts\SeoMetaServiceInterface;
use App\Services\Contracts\UserAdminServiceInterface;
use Error;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;

class UsersController extends Controller
{
    public function __construct(
        protected readonly SeoMetaServiceInterface $seoMetaService,
        protected readonly FlashMessageServiceInterface $flashMessageService,
        protected readonly LoggerInterface $logService,
        protected readonly UserAdminServiceInterface $userAdminService
    ) {
    }

    public function index(): View
    {
        $this->seoMetaService->setTitle(__('Users'));

        return view('admin.users.index');
    }

    public function create(): View
    {
        $this->seoMetaService->setTitle(__('Users'));

        return view('admin.users.create');
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        $data = CreateUserAdminData::fromArray(
            $request->only(['first_name', 'last_name', 'email', 'password'])
        );

        try {
            $user = $this->userAdminService->register($data, Auth::user());
            $this->flashMessageService->success(
                __('New user has been registered.')
            );

            return redirect()->route('admin.user.show', $user);
        } catch (Exception | Error $e) {
            $this->logService->error($e->getMessage());
            $this->flashMessageService->internalServerError();

            return redirect()->back()->withInput();
        }
    }
}
