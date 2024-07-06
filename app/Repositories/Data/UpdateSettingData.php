<?php

declare(strict_types=1);

namespace App\Repositories\Data;

final class UpdateSettingData
{
    public function __construct(
        public readonly string $app_name,
        public readonly bool $registration_enabled,
    ) {
        //
    }
}
