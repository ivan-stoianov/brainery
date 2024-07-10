<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Data\CreateUserAdminData;
use App\Data\UpdateUserAdminData;
use App\Models\User;

interface UserAdminServiceInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function register(CreateUserAdminData $data, User $author): User;

    public function update(User $userAdmin, UpdateUserAdminData $data, User $author): User;

    public function enableAccount(User $userAdmin, User $updaterUser): bool;

    public function disableAccount(User $userAdmin, User $updaterUser): bool;
}
