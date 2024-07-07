<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Stringable;

interface SeoMetaServiceInterface
{
    public function generate(): Stringable;

    public function setTitle(string $title): void;

    public function setDescription(string $description): void;
}
