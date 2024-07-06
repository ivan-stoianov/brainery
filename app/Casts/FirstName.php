<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class FirstName implements CastsAttributes
{
    /**
     * Define minimum number of characters
     */
    protected const MIN_CHARACTERS = 2;

    /**
     * Define maximum number of characters
     */
    protected const MAX_CHARACTERS = 40;

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (strlen($value) < self::MIN_CHARACTERS) {
            throw new InvalidArgumentException(
                sprintf('The first name must have at least %d characters.', self::MIN_CHARACTERS)
            );
        }

        if (strlen($value) > self::MAX_CHARACTERS) {
            throw new InvalidArgumentException(
                sprintf('The first name must have max %d characters.', self::MAX_CHARACTERS)
            );
        }

        // Must include only letters, hyphens, apostrophes, and spaces.
        if (!preg_match("/^[a-zA-Z\s\-\.\']+$/", $value)) {
            throw new InvalidArgumentException('The first name is not valid.');
        }

        return $value;
    }
}
