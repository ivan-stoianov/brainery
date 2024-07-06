<?php

namespace App\Models;

use Illuminate\Support\Carbon;

trait HasDefaultGetters
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
}
