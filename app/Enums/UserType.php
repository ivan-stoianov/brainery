<?php

declare(strict_types=1);

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';

    public function label(): string
    {
        return match ($this) {
            UserType::ADMIN => __('Admin'),
            UserType::MEMBER => __('Member'),
        };
    }
}
