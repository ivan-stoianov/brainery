<?php

declare(strict_types=1);

namespace App\Data;

final readonly class CreateUserAdminData implements DataInterface
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $password,
        public bool $active = true,
    ) {
    }

    public static function fromArray(array $fields): CreateUserAdminData
    {
        return new CreateUserAdminData(
            first_name: $fields['first_name'],
            last_name: $fields['last_name'],
            email: $fields['email'],
            password: $fields['password'],
            active: $fields['active'] ?? true,
        );
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
