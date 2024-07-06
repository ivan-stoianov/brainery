<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\CreateUserAdminData;
use App\Enums\UserType;
use App\Models\User;
use App\Repositories\Contracts\UserAdminRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAdminRepository implements UserAdminRepositoryInterface
{
    public function __construct(
        protected readonly User $user,
        protected readonly CacheInterface $cacheRepository,
    ) {
    }

    public function query(): Builder
    {
        return $this->user->newQuery()->onlyAdmin();
    }

    public function findById(int $id): ?User
    {
        return $this->cacheRepository->remember("users.admin.{$id}", 60 * 5, function () use ($id) {
            return $this->query()->find($id);
        });
    }

    public function findByEmail(string $email): ?User
    {
        return $this->cacheRepository->remember("users.admin.{$email}", 60 * 5, function () use ($email) {
            return $this->query()->where('email', '=', $email)->first();
        });
    }

    public function register(CreateUserAdminData $data): Model
    {
        return DB::transaction(function () use ($data) {
            $user  = $this->user->create([
                'admin' => $data->active,
                'type' => UserType::ADMIN,
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'email' => $data->email,
                'password' => Hash::make($data->password),
            ]);

            return $user;
        });
    }

    protected function clearMemberCache(User $member): bool
    {
        return $this->cacheRepository->deleteMultiple([
            "users.admin.{$member->getId()}",
            "users.admin.{$member->getEmail()}",
        ]);
    }
}
