<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\CreateUserAdminData;
use App\Data\UpdateUserAdminData;
use App\Enums\UserType;
use App\Models\User;
use App\Repositories\Contracts\UserAdminRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserAdminRepository implements UserAdminRepositoryInterface
{
    public function __construct(
        protected readonly User $user,
    ) {
    }

    public function query(): Builder
    {
        return $this->user->newQuery()->onlyAdmin();
    }

    public function findById(int $id): ?User
    {
        return $this->query()->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->query()->where('email', '=', $email)->first();
    }

    public function register(CreateUserAdminData $data): User
    {
        return $this->user->create([
            'admin' => $data->active,
            'type' => UserType::ADMIN,
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
    }

    public function update(User $userAdmin, UpdateUserAdminData $data): bool
    {
        $userAdmin->fill([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
        ]);

        if (!$userAdmin->isDirty()) {
            return false;
        }

        return $userAdmin->save();
    }

    public function enableAccount(User $userAdmin): bool
    {
        $userAdmin->fill([
            'active' => true,
        ]);

        if (!$userAdmin->isDirty()) {
            return false;
        }

        return $userAdmin->save();
    }

    public function disableAccount(User $userAdmin): bool
    {
        $userAdmin->fill([
            'active' => false,
        ]);

        if (!$userAdmin->isDirty()) {
            return false;
        }

        return $userAdmin->save();
    }
}
