<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FlashMessage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'flash.message';
    }
}
