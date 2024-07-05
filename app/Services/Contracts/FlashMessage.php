<?php

namespace App\Services\Contracts;

use Stringable;

interface FlashMessage
{
    public function success(string $message): void;

    public function warning(string $message): void;

    public function error(string $message): void;

    public function display(): ?Stringable;
}
