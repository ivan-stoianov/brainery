<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\CreateUserAdminData;
use App\Events\UserAdminCreated;
use App\Models\User;
use App\Repositories\Contracts\UserAdminRepositoryInterface;
use App\Services\Contracts\ActivityLogServiceInterface;
use App\Services\Contracts\UserAdminServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserAdminService implements UserAdminServiceInterface
{
    public function __construct(
        protected readonly UserAdminRepositoryInterface $userAdminRepository,
        protected readonly ActivityLogServiceInterface $activityLogService,
    ) {
    }

    public function register(CreateUserAdminData $data, User $author): Model
    {
        return DB::transaction(
            function () use ($data, $author) {
                $newUser = $this->userAdminRepository->register($data);

                $this->activityLogService->record(
                    description: __('User :name has been registered.', ['name' => $newUser->getName()]),
                    event: "admin.users.admin.created",
                    subject: $newUser,
                    causer: $author
                );

                UserAdminCreated::dispatch($newUser->getId());

                return $newUser;
            }
        );
    }
}
