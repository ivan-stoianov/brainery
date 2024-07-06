<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class Email implements CastsAttributes
{
    protected const MAX_LENGTH = 200;
    protected const USERNAME_MAX_LENGTH = 60;
    protected const DOMAIN_MAX_LENGTH = 139;

    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'The email address is not valid.'
            );
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw new InvalidArgumentException(
                sprintf("The email address cannot have more than %d characters.", self::MAX_LENGTH)
            );
        }

        list($username, $domain) = explode('@', $value);

        if (strlen($username) > self::USERNAME_MAX_LENGTH) {
            throw new InvalidArgumentException(
                sprintf('The username from email address cannot have more than %d characters.', self::USERNAME_MAX_LENGTH)
            );
        }

        if (strlen($domain) > self::DOMAIN_MAX_LENGTH) {
            throw new InvalidArgumentException(
                sprintf('The domain from email address cannot have more than %d characters.', self::DOMAIN_MAX_LENGTH)
            );
        }

        return strtolower($value);
    }
}
