<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IntervalItemTimerRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !\Validator::make($value, [
            'before' => 'sometimes|numeric',
            'work' => 'required|numeric|min:1',
            'rest' => 'required|numeric|min:1',
            'sets' => 'required|numeric|min:1',
            'cycles' => 'required|numeric|min:1',
            'betweenCycles' => 'sometimes|numeric',
            'after' => 'sometimes|numeric',
        ])->fails();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.item_timer');
    }
}
