<?php

namespace App\Services;

use App\Services\Contracts\FlashMessageInterface;
use Illuminate\Support\HtmlString;
use Stringable;

class FlashMessageService implements FlashMessageInterface
{
    public function __construct()
    {
        \Spatie\Flash\Flash::levels([
            'success' => 'alert alert-success',
            'warning' => 'alert alert-warning',
            'error' => 'alert alert-danger',
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

    public function internalServerError(?string $message = null): void
    {
        flash()->error(
            $message ??=
                __("Oops! Something went wrong. We're experiencing a temporary hiccup on our end. Please try again in a few moments.")
        );
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
