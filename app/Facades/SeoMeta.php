<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SeoMeta extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'seo.meta.tools';
    }
}
