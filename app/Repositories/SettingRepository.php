<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\UpdateSettingData;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Settings\AppSetting;
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
            $results = [];

            $this->appSetting->name = $data->app_name;
            $this->appSetting->registration_enabled = $data->registration_enabled;

            if (!$this->appSetting->save()) {
                $results[] = false;
            }

            foreach ($results as $result) {
                if (!$result) {
                    return false;
                }
            }

            return true;
        });
    }
}
