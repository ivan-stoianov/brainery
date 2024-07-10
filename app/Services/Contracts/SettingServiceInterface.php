<?php

namespace App\Services\Contracts;

use App\Data\UpdateSettingData;
use App\Models\User;

interface SettingServiceInterface
{
    public function update(UpdateSettingData $data, User $userUpdater): bool;
}
