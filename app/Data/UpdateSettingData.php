<?php

declare(strict_types=1);

namespace App\Data;

final readonly class UpdateSettingData implements DataInterface
{
    public function __construct(
        public string $app_name,
        public bool $registration_enabled,
    ) {
    }

    public function toArray(): array
    {
        return [
            'app_name' => $this->app_name,
            'registration_enabled' => $this->registration_enabled,
        ];
    }

    public static function fromArray(array $fields): UpdateSettingData
    {
        return new UpdateSettingData(
            app_name: $fields['app_name'],
            registration_enabled: $fields['registration_enabled'],
        );
    }
}
