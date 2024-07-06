<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Settings\AppSetting;
use Illuminate\View\View;

class AppSettingComposer
{
    public function __construct(
        protected readonly AppSetting $appSetting
    ) {
        //
    }

    public function compose(View $view): void
    {
        $view->with([
            'app_name' => $this->appSetting->name,
            'registration_enabled' => $this->appSetting->registration_enabled,
        ]);
    }
}
