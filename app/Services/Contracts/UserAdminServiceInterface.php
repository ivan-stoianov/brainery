<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Data\CreateUserAdminData;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserAdminServiceInterface
{
    public function register(CreateUserAdminData $data, User $author): Model;
}
