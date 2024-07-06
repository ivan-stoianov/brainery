<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface AdminInterface
{
    public function query(): Builder;

    public function findById(int $id): ?Model;

    public function findByEmail(string $email): ?Model;
}
