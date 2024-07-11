<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Data\CreateUserAdminData;
use App\Data\UpdateUserAdminData;
use App\Models\User;

interface UserAdminServiceInterface
{

    /**
     * Find user admin by id.
     *
     * @param int $id
     * @return ?User
     */
    public function findById(int $id): ?User;

    /**
     * Find user admin by email.
     *
     * @param string $email
     * @return ?User
     */
    public function findByEmail(string $email): ?User;

    /**
     * Register new user admin.
     *
     * @param CreateUserAdminData $data
     * @param User $author
     * @return User
     */
    public function register(CreateUserAdminData $data, User $author): User;

    /**
     * Update user admin.
     *
     * @param UpdateUserAdminData $data
     * @param User $author
     * @return User
     */
    public function update(User $userAdmin, UpdateUserAdminData $data, User $author): User;

    /**
     * Enable user admin account.
     *
     * @param User $userAdmin
     * @param User $updaterUser
     * @return bool
     */
    public function enableAccount(User $userAdmin, User $updaterUser): bool;

    /**
     * Disable user admin account.
     *
     * @param User $userAdmin
     * @param User $updaterUser
     * @return bool
     */
    public function disableAccount(User $userAdmin, User $updaterUser): bool;
}
