<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\UpdateSettingData;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Settings\AppSetting;
use Exception;
use Illuminate\Support\Facades\DB;

class SettingRepository implements SettingRepositoryInterface
{
    public function __construct(
        protected readonly AppSetting $appSetting
    ) {
    }

    public function update(UpdateSettingData $data): bool
    {
        return DB::transaction(function () use ($data) {
            $this->appSetting->name = $data->app_name;
            $this->appSetting->registration_enabled = $data->registration_enabled;

            if (!$this->appSetting->save()) {
                throw new Exception(__('The app settings cannot be saved.'));
            }

            return true;
        });
    }
}
