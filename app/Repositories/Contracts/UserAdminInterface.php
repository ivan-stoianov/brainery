<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Repositories\Data\CreateUserAdminData;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UserAdminInterface
{
    public function query(): Builder;

    public function findById(int $id): ?Model;

    public function findByEmail(string $email): ?Model;

    public function register(CreateUserAdminData $data): Model;
}
