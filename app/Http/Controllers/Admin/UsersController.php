<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\CreateUserRequest;
use App\Repositories\Contracts\UserAdminInterface;
use App\Repositories\Data\CreateUserAdminData;
use App\Services\Contracts\FlashMessageInterface;
use App\Services\Contracts\SeoMetaInterface;
use Error;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;

class UsersController extends Controller
{
    public function __construct(
        protected readonly SeoMetaInterface $seoMeta,
        protected readonly FlashMessageInterface $flashMessage,
        protected readonly LoggerInterface $logger,
        protected readonly UserAdminInterface $userAdminRepository
    ) {
    }

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Users'));

        return view('admin.users.index');
    }

    public function create(): View
    {
        $this->seoMeta->setTitle(__('Users'));

        return view('admin.users.create');
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        try {
            $data = new CreateUserAdminData(
                first_name: $request->get('first_name'),
                last_name: $request->get('last_name'),
                email: $request->get('email'),
                password: $request->get('password'),
            );

            $user = $this->userAdminRepository->register($data);

            $this->flashMessage->success(
                __('New user has been registered.')
            );

            return redirect()->route('admin.user.show', $user);
        } catch (Exception | Error $e) {
            $this->logger->error($e->getMessage());

            $this->flashMessage->internalServerError();

            return redirect()->back()->withInput();
        }
    }
}
