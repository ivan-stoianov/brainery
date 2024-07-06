<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\UpdateSettingRequest;
use App\Repositories\Contracts\SettingInterface;
use App\Repositories\Data\UpdateSettingData;
use App\Services\Contracts\FlashMessageInterface;
use App\Services\Contracts\SeoMetaInterface;
use App\Settings\AppSetting;
use Error;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Log\Logger;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __construct(
        protected readonly SeoMetaInterface $seoMeta,
        protected readonly FlashMessageInterface $flashMessage,
        protected readonly AppSetting $appSetting,
        protected readonly SettingInterface $settingRepository,
        protected readonly Logger $logger
    ) {
    }

    public function edit(): View
    {
        $this->seoMeta->setTitle(__('Settings'));

        return view('admin.settings.edit', [
            'app_name' => $this->appSetting->name,
            'registration_enabled' => $this->appSetting->registration_enabled,
        ]);
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        try {
            $data = new UpdateSettingData(
                app_name: $request->string('app_name'),
                registration_enabled: $request->boolean('registration_enabled'),
            );

            $saved = $this->settingRepository->update($data);

            if (!$saved) {
                throw new Exception(__('The settings not saved.'));
            }

            $this->flashMessage->success(
                __('Settings has been updated.')
            );
        } catch (Exception | Error $e) {
            $this->logger->error($e->getMessage());

            $this->flashMessage->internalServerError();
        }

        return redirect()->back();
    }
}
