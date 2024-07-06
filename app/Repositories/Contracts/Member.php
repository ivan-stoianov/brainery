<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface Member
{
    public function query(): Builder;

    public function findById(int $id): User|null;

    public function findByEmail(string $email): User|null;
}
