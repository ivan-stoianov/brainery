<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserAdminRepositoryInterface;
use App\Services\Contracts\UserAdminCacheServiceInterface;
use Illuminate\Contracts\Cache\Repository as CacheInterface;

class UserAdminCacheService implements UserAdminCacheServiceInterface
{
    public function __construct(
        protected readonly UserAdminRepositoryInterface $userAdminRepository,
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

    public function forget(?User $userAdmin = null): bool
    {
        return $this->cacheRepository->deleteMultiple([
            "users.admin.{$userAdmin->getId()}",
            "users.admin.{$userAdmin->getEmail()}",
        ]);
    }
}
