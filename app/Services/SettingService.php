<?php

namespace App\Services;

use App\Data\UpdateSettingData;
use App\Enums\ActivityLogEventName;
use App\Models\User;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Services\Contracts\ActivityLogServiceInterface;
use App\Services\Contracts\SettingServiceInterface;
use Illuminate\Support\Facades\DB;

class SettingService implements SettingServiceInterface
{
    public function __construct(
        protected readonly SettingRepositoryInterface $settingRepository,
        protected readonly ActivityLogServiceInterface $activityLogService
    ) {
    }

    public function update(UpdateSettingData $data, User $userUpdater): bool
    {
        return DB::transaction(function () use ($data, $userUpdater) {
            $saved = $this->settingRepository->update($data);

            if (!$saved) {
                return false;
            }

            $this->activityLogService->record(
                description: __("Application settings has been updated."),
                event: ActivityLogEventName::ADMIN_SETTINGS_UPDATED,
                subject: null,
                causer: $userUpdater
            );

            return $saved;
        });
    }
}
