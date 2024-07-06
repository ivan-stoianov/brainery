<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserMemberInterface;
use Illuminate\Contracts\Cache\Repository as CacheInterface;
use Illuminate\Database\Eloquent\Builder;

class UserMemberRepository implements UserMemberInterface
{
    public function __construct(
        protected readonly User $user,
        protected readonly CacheInterface $cacheRepository
    ) {
    }

    public function query(): Builder
    {
        return $this->user->newQuery()->onlyMember();
    }

    public function findById(int $id): ?User
    {
        return $this->cacheRepository->remember("members.{$id}", 60 * 5, function () use ($id) {
            return $this->user->find($id);
        });
    }

    public function findByEmail(string $email): ?User
    {
        return $this->cacheRepository->remember("members.{$email}", 60 * 5, function () use ($email) {
            return $this->query()->where('email', '=', $email)->first();
        });
    }

    protected function clearMemberCache(User $member): bool
    {
        return $this->cacheRepository->deleteMultiple([
            "members.{$member->getId()}",
            "members.{$member->getEmail()}",
        ]);
    }
}
