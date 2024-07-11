<?php

namespace App\Services\Contracts;

use BackedEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ActivityLogServiceInterface
{
    public function getPaginatedByCauser(Model $causer): LengthAwarePaginator;

    public function record(
        string $description,
        string|BackedEnum $event,
        Model $subject = null,
        Model $causer = null
    ): void;
}
