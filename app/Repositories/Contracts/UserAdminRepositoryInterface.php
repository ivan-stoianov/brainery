<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Data\CreateUserAdminData;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UserAdminRepositoryInterface
{
    public function query(): Builder;

    public function findById(int $id): ?Model;

    public function findByEmail(string $email): ?Model;

    public function register(CreateUserAdminData $data): Model;
}
