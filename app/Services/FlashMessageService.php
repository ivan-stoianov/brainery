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
            'success' => 'alert alert-success',
            'warning' => 'alert alert-warning',
            'error' => 'alert alert-error',
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

    public function display($dismissible = true): ?Stringable
    {
        if (!flash()->message) {
            return null;
        }

        $dismissButton = '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

        if ($dismissible) {
            return new HtmlString(
                sprintf(
                    '<div class="%s alert-dismissible fade show" role="alert">%s %s</div>',
                    flash()->class,
                    flash()->message,
                    $dismissButton
                )
            );
        }

        return new HtmlString(
            sprintf('<div class="%s" role="alert">%s</div>', flash()->class, flash()->message)
        );
    }
}
