<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Data\UpdateUserAdminData;
use App\Exceptions\Admin\UserAdminNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Settings\UpdateUserAdminRequest;
use App\Services\Contracts\FlashMessageServiceInterface;
use App\Services\Contracts\SeoMetaServiceInterface;
use App\Services\Contracts\UserAdminServiceInterface;
use Error;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;

class SettingsController extends Controller
{
    public function __construct(
        protected readonly UserAdminServiceInterface $userAdminService,
        protected readonly SeoMetaServiceInterface $seoMetaService,
        protected readonly FlashMessageServiceInterface $flashMessageService,
        protected readonly LoggerInterface $logService,
    ) {
    }

    public function index(int $userId): View
    {
        $user = $this->userAdminService->findById($userId);
        if (!$user) {
            throw new UserAdminNotFoundException();
        }

        $this->seoMetaService->setTitle($user->getName());

        return view('admin.user.settings', compact('user'));
    }

    public function update(UpdateUserAdminRequest $request, int $userId): RedirectResponse
    {
        $userAdmin = $this->userAdminService->findById($userId);
        if (!$userAdmin) {
            throw new UserAdminNotFoundException();
        }

        $data = UpdateUserAdminData::fromArray(
            $request->only(['first_name', 'last_name'])
        );

        try {
            $saved = $this->userAdminService->update($userAdmin, $data, Auth::user());

            if ($saved) {
                $this->flashMessageService->success(
                    __('User :name has been updated.', ['name' => $userAdmin->getName()])
                );
            }
        } catch (Exception | Error $e) {
            $this->logService->error($e->getMessage());
            $this->flashMessageService->internalServerError();
        }

        return redirect()->back();
    }

    public function disableAccount(int $userId): RedirectResponse
    {
        $userAdmin = $this->userAdminService->findById($userId);
        if (!$userAdmin) {
            throw new UserAdminNotFoundException();
        }

        if (Gate::denies('disableAccount', $userAdmin)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        try {
            $success = $this->userAdminService->disableAccount($userAdmin, Auth::user());

            if ($success) {
                $this->flashMessageService->success(
                    __('User :name has been disabled.', ['name' => $userAdmin->getName()])
                );
            }
        } catch (Exception | Error $e) {
            $this->logService->error($e->getMessage());
            $this->flashMessageService->internalServerError();
        }

        return redirect()->back();
    }

    public function enableAccount(int $userId): RedirectResponse
    {
        $userAdmin = $this->userAdminService->findById($userId);
        if (!$userAdmin) {
            throw new UserAdminNotFoundException();
        }

        if (Gate::denies('enableAccount', $userAdmin)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        try {
            $success = $this->userAdminService->enableAccount($userAdmin, Auth::user());

            if ($success) {
                $this->flashMessageService->success(
                    __('User :name has been enabled.', ['name' => $userAdmin->getName()])
                );
            }
        } catch (Exception | Error $e) {
            $this->logService->error($e->getMessage());
            $this->flashMessageService->internalServerError();
        }

        return redirect()->back();
    }
}
