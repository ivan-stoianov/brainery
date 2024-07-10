<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\CreateUserAdminData;
use App\Data\UpdateUserAdminData;
use App\Events\UserAdminCreated;
use App\Events\UserAdminUpdated;
use App\Models\User;
use App\Repositories\Contracts\UserAdminRepositoryInterface;
use App\Services\Contracts\ActivityLogServiceInterface;
use App\Services\Contracts\UserAdminServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Cache\Repository as CacheInterface;

class UserAdminService implements UserAdminServiceInterface
{
    public function __construct(
        protected readonly UserAdminRepositoryInterface $userAdminRepository,
        protected readonly ActivityLogServiceInterface $activityLogService,
        protected readonly CacheInterface $cacheRepository,
    ) {
    }

    public function findById(int $id): ?User
    {
        return $this->cacheRepository->remember("users.admin.{$id}", 60 * 5, function () use ($id) {
            return $this->userAdminRepository->findById($id);
        });
    }

    public function findByEmail(string $email): ?User
    {
        return $this->cacheRepository->remember("users.admin.{$email}", 60 * 5, function () use ($email) {
            return $this->userAdminRepository->findByEmail($email);
        });
    }

    public function register(CreateUserAdminData $data, User $author): User
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

    public function update(User $userAdmin, UpdateUserAdminData $data, User $author): User
    {
        return DB::transaction(function () use ($userAdmin, $data, $author) {
            $this->userAdminRepository->update($userAdmin, $data);

            $this->activityLogService->record(
                description: __('User :name has been updated.', ['name' => $userAdmin->getName()]),
                event: "admin.users.admin.updated",
                subject: $userAdmin,
                causer: $author
            );

            $this->clearMemberCache($userAdmin);

            UserAdminUpdated::dispatch($userAdmin->getId());

            return $userAdmin;
        });
    }

    public function disableAccount(User $userAdmin, User $updaterUser): bool
    {
        return DB::transaction(function () use ($userAdmin, $updaterUser) {
            $disabled = $this->userAdminRepository->disableAccount($userAdmin);
            if (!$disabled) {
                return false;
            }

            $this->activityLogService->record(
                description: __('User :name account has been disabled.', ['name' => $userAdmin->getName()]),
                event: "admin.users.admin.disabled",
                subject: $userAdmin,
                causer: $updaterUser
            );

            $this->clearMemberCache($userAdmin);

            //

            return true;
        });
    }

    public function enableAccount(User $userAdmin, User $updaterUser): bool
    {
        return DB::transaction(function () use ($userAdmin, $updaterUser) {
            $enabled = $this->userAdminRepository->enableAccount($userAdmin);

            if (!$enabled) {
                return false;
            }

            $this->activityLogService->record(
                description: __('User :name account has been enabled.', ['name' => $userAdmin->getName()]),
                event: "admin.users.admin.enabled",
                subject: $userAdmin,
                causer: $updaterUser
            );

            $this->clearMemberCache($userAdmin);

            //

            return true;
        });
    }

    protected function clearMemberCache(User $userAdmin): bool
    {
        return $this->cacheRepository->deleteMultiple([
            "users.admin.{$userAdmin->getId()}",
            "users.admin.{$userAdmin->getEmail()}",
        ]);
    }
}
