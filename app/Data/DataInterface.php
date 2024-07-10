<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Contracts\Support\Arrayable;

interface DataInterface extends Arrayable
{
    public static function fromArray(array $fields): self;
}
