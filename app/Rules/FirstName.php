<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FirstName implements ValidationRule
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
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) > self::MAX_CHARACTERS) {
            $fail(
                sprintf('The first name must have max %d characters.', self::MAX_CHARACTERS)
            );
        }

        if (strlen($value) > self::MAX_CHARACTERS) {
            $fail(
                sprintf('The first name must have max %d characters.', self::MAX_CHARACTERS)
            );
        }

        if (!preg_match("/^[a-zA-Z\s\-\.\']+$/", $value)) {
            $fail(__('The first name is not valid.'));
        }
    }
}
