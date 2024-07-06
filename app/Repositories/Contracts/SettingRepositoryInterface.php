<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Data\UpdateSettingData;

interface SettingRepositoryInterface
{
    public function update(UpdateSettingData $data): bool;
}
