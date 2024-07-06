<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Contracts\Support\Arrayable;

final class CreateUserAdminData implements Arrayable
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

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'active' => $this->active,
        ];
    }
}
