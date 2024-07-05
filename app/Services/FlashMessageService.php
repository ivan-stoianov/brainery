<?php

namespace App\Services;

use App\Services\Contracts\FlashMessage;
use Illuminate\Support\HtmlString;
use Stringable;

class FlashMessageService implements FlashMessage
{
    public function __construct()
    {
        \Spatie\Flash\Flash::levels([
            'success' => 'alert-success',
            'warning' => 'alert-warning',
            'error' => 'alert-error',
        ]);
    }

    public function success(string $message): void
    {
        flash()->success($message);
    }

    public function warning(string $message): void
    {
        flash()->warning($message);
    }

    public function error(string $message): void
    {
        flash()->error($message);
    }

    public function display(): ?Stringable
    {
        if (!flash()->message) {
            return null;
        }

        return new HtmlString(
            sprintf('<div class="%s">%s</div>', flash()->class, flash()->message)
        );
    }
}
