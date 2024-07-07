<?php

namespace App\Services;

use App\Data\UpdateSettingData;
use App\Models\User;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Services\Contracts\ActivityLogServiceInterface;
use App\Services\Contracts\SettingServiceInterface;
use Illuminate\Support\Facades\DB;

class SettingService implements SettingServiceInterface
{
    public function __construct(
        protected readonly SettingRepositoryInterface $settingServiceInterface,
        protected readonly ActivityLogServiceInterface $activityLogServiceInterface
    ) {
    }

    public function update(UpdateSettingData $data, User $updatedBy): bool
    {
        return DB::transaction(
            function () use ($data, $updatedBy) {
                $saved = $this->settingServiceInterface->update($data);

                if (!$saved) {
                    return false;
                }

                $this->activityLogServiceInterface->record(
                    description: __("Application settings has been updated."),
                    event: "admin.settings.updated",
                    subject: null,
                    causer: $updatedBy
                );

                return $saved;
            }
        );
    }
}
