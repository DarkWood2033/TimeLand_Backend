<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ConstructorItemTimerRule implements Rule
{
    private const TYPE = ['work', 'rest', 'before', 'after'];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(is_array($value)) {
            $count = count($value);
            for ($i = 0; $i < $count; $i++){
                $item = $value[$i];
                if(is_array($item)){
                    if(empty($item['type'])) return false;
                    if(empty($item['time'])) return false;
                    if(empty($item['name'])) return false;
                    if(!in_array($item['type'], ConstructorItemTimerRule::TYPE)) return false;
                    if(!(1 <= $item['time'] && $item['time'] <= 3599)) return false;
                    if(!is_string($item['name']) && 3 <= mb_strlen($item['name'])) return false;
                }
            }
            return true;
        }
        return false;
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
