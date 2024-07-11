<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\CreateUserAdminData;
use App\Data\UpdateUserAdminData;
use App\Enums\ActivityLogEventName;
use App\Events\UserAdminCreated;
use App\Events\UserAdminUpdated;
use App\Models\User;
use App\Repositories\Contracts\UserAdminRepositoryInterface;
use App\Services\Contracts\ActivityLogServiceInterface;
use App\Services\Contracts\UserAdminCacheServiceInterface;
use App\Services\Contracts\UserAdminServiceInterface;
use Illuminate\Support\Facades\DB;

class UserAdminService implements UserAdminServiceInterface
{
    public function __construct(
        protected readonly UserAdminRepositoryInterface $userAdminRepository,
        protected readonly UserAdminCacheServiceInterface $userAdminCacheService,
        protected readonly ActivityLogServiceInterface $activityLogService,
    ) {
    }

    /**
     * Find user admin by id.
     *
     * @param int $id
     * @return ?User
     */
    public function findById(int $id): ?User
    {
        return $this->userAdminCacheService->findById($id);
    }

    /**
     * Find user admin by email.
     *
     * @param string $email
     * @return ?User
     */
    public function findByEmail(string $email): ?User
    {
        return $this->userAdminCacheService->findByEmail($email);
    }

    /**
     * Register new user admin.
     *
     * @param CreateUserAdminData $data
     * @param User $author
     * @return User
     */
    public function register(CreateUserAdminData $data, User $author): User
    {
        return DB::transaction(function () use ($data, $author) {
            $newUser = $this->userAdminRepository->register($data);

            $this->activityLogService->record(
                description: __('User :name has been registered.', ['name' => $newUser->getName()]),
                event: ActivityLogEventName::USER_ADMIN_CREATED,
                subject: $newUser,
                causer: $author
            );

            UserAdminCreated::dispatch($newUser->getId());

            return $newUser;
        });
    }

    /**
     * Update user admin.
     *
     * @param UpdateUserAdminData $data
     * @param User $author
     * @return User
     */
    public function update(User $userAdmin, UpdateUserAdminData $data, User $author): User
    {
        return DB::transaction(function () use ($userAdmin, $data, $author) {
            $this->userAdminRepository->update($userAdmin, $data);

            $this->activityLogService->record(
                description: __('User :name has been updated.', ['name' => $userAdmin->getName()]),
                event: ActivityLogEventName::USER_ADMIN_UPDATED,
                subject: $userAdmin,
                causer: $author
            );

            $this->userAdminCacheService->forget($userAdmin);

            UserAdminUpdated::dispatch($userAdmin->getId());

            return $userAdmin;
        });
    }

    /**
     * Enable user admin account.
     *
     * @param User $userAdmin
     * @param User $updaterUser
     * @return bool
     */
    public function enableAccount(User $userAdmin, User $updaterUser): bool
    {
        return DB::transaction(function () use ($userAdmin, $updaterUser) {
            $enabled = $this->userAdminRepository->enableAccount($userAdmin);

            if (!$enabled) {
                return false;
            }

            $this->activityLogService->record(
                description: __('User :name account has been enabled.', ['name' => $userAdmin->getName()]),
                event: ActivityLogEventName::USER_ADMIN_ENABLED,
                subject: $userAdmin,
                causer: $updaterUser
            );

            $this->userAdminCacheService->forget($userAdmin);

            //

            return true;
        });
    }

    /**
     * Disable user admin account.
     *
     * @param User $userAdmin
     * @param User $updaterUser
     * @return bool
     */
    public function disableAccount(User $userAdmin, User $updaterUser): bool
    {
        return DB::transaction(function () use ($userAdmin, $updaterUser) {
            $disabled = $this->userAdminRepository->disableAccount($userAdmin);
            if (!$disabled) {
                return false;
            }

            $this->activityLogService->record(
                description: __('User :name account has been disabled.', ['name' => $userAdmin->getName()]),
                event: ActivityLogEventName::USER_ADMIN_DISABLED,
                subject: $userAdmin,
                causer: $updaterUser
            );

            $this->userAdminCacheService->forget($userAdmin);

            //

            return true;
        });
    }
}
