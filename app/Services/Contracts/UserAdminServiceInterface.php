<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Data\CreateUserAdminData;
use Illuminate\Database\Eloquent\Model;

interface UserAdminServiceInterface
{
    public function register(CreateUserAdminData $data): Model;
}
