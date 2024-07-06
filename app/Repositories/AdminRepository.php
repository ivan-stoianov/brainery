<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\AdminInterface;
use Illuminate\Contracts\Cache\Repository as CacheInterface;
use Illuminate\Database\Eloquent\Builder;

class AdminRepository implements AdminInterface
{
    public function __construct(
        protected readonly User $user,
        protected readonly CacheInterface $cacheRepository
    ) {
    }

    public function query(): Builder
    {
        return $this->user->newQuery()->onlyAdmin();
    }

    public function findById(int $id): ?User
    {
        return $this->cacheRepository->remember("admin.{$id}", 60 * 5, function () use ($id) {
            return $this->user->find($id);
        });
    }

    public function findByEmail(string $email): ?User
    {
        return $this->cacheRepository->remember("admin.{$email}", 60 * 5, function () use ($email) {
            return $this->query()->where('email', '=', $email)->first();
        });
    }

    protected function clearMemberCache(User $member): bool
    {
        return $this->cacheRepository->deleteMultiple([
            "admin.{$member->getId()}",
            "admin.{$member->getEmail()}",
        ]);
    }
}
