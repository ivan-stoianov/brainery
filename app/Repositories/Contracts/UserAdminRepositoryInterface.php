<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Data\CreateUserAdminData;
use App\Data\UpdateUserAdminData;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface UserAdminRepositoryInterface
{
    public function query(): Builder;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function register(CreateUserAdminData $data): ?User;

    public function update(User $user, UpdateUserAdminData $data): bool;

    public function enableAccount(User $userAdmin): bool;

    public function disableAccount(User $userAdmin): bool;
}
