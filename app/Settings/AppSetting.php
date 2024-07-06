<?php

declare(strict_types=1);

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AppSetting extends Settings
{
    public string $name;

    public bool $registration_enabled;

    public static function group(): string
    {
        return 'default';
    }
}
