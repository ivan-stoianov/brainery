<?php

declare(strict_types=1);

namespace App\Repositories\Data;

final class CreateUserAdminData
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $password,
        public readonly bool $active = true,
    ) {
        //
    }
}
