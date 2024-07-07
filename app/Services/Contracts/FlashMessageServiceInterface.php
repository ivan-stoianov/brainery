<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Stringable;

interface FlashMessageServiceInterface
{
    public function success(string $message): void;

    public function warning(string $message): void;

    public function error(string $message): void;

    public function internalServerError(?string $message = null): void;

    public function display(): ?Stringable;
}
