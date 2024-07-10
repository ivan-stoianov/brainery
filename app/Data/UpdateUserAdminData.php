<?php

declare(strict_types=1);

namespace App\Data;

final readonly class UpdateUserAdminData implements DataInterface
{
    public function __construct(
        public string $first_name,
        public string $last_name,
    ) {
    }

    public static function fromArray(array $fields): UpdateUserAdminData
    {
        return new UpdateUserAdminData(
            first_name: $fields['first_name'],
            last_name: $fields['last_name'],
        );
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
    }
}
