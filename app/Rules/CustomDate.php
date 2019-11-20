<?php

namespace App\Rules;

use App\Helper\DateHelper;
use Illuminate\Contracts\Validation\Rule;

class CustomDate implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DateHelper::parseDate($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Неправильная дата.';
    }
}
