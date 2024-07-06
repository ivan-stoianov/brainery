<?php

namespace App\Services\Contracts;

use Stringable;

interface SeoMetaInterface
{
    public function generate(): Stringable;

    public function setTitle(string $title): void;

    public function setDescription(string $description): void;
}