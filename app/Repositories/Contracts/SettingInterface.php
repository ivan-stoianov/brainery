<?php

namespace App\Repositories\Contracts;

use App\Repositories\Data\UpdateSettingData;

interface SettingInterface
{
    public function update(UpdateSettingData $data): bool;
}