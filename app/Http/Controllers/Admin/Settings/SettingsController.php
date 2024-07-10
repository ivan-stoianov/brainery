<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Settings;

use App\Data\UpdateSettingData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\UpdateSettingRequest;
use App\Services\Contracts\FlashMessageServiceInterface;
use App\Services\Contracts\SeoMetaServiceInterface;
use App\Services\Contracts\SettingServiceInterface;
use App\Settings\AppSetting;
use Error;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __construct(
        protected readonly SeoMetaServiceInterface $seoMetaService,
        protected readonly FlashMessageServiceInterface $flashMessageService,
        protected readonly AppSetting $appSetting,
        protected readonly SettingServiceInterface $settingService,
        protected readonly Logger $logService
    ) {
    }

    public function edit(): View
    {
        $this->seoMetaService->setTitle(__('Settings'));

        return view('admin.settings.edit', [
            'app_name' => $this->appSetting->name,
            'registration_enabled' => $this->appSetting->registration_enabled,
        ]);
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $data = UpdateSettingData::fromArray([
            'app_name' => $request->get('app_name'),
            'registration_enabled' => $request->boolean('registration_enabled'),
        ]);

        try {
            $saved = $this->settingService->update($data, Auth::user());

            if ($saved) {
                $this->flashMessageService->success(
                    __('Settings has been updated.')
                );
            }
        } catch (Exception | Error $e) {
            $this->logService->error($e->getMessage());

            $this->flashMessageService->internalServerError();
        }

        return redirect()->back();
    }
}
