<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\User;

interface UserAdminCacheServiceInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function forget(?User $userAdmin = null): bool;
}
