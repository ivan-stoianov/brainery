<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;

trait HasDefaultGetters
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): CarbonInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): CarbonInterface
    {
        return $this->updated_at;
    }
}
