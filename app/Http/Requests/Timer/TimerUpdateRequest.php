<?php

namespace App\Http\Requests\Timer;

use App\Entities\ItemTimer\ConstructorItemTimer;
use App\Entities\ItemTimer\IntervalItemTimer;
use App\Rules\ConstructorItemTimerRule;
use App\Rules\IntervalItemTimerRule;
use App\Rules\TimerItemRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TimerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'min:6', 'max:255'],
            'type' => ['required', Rule::in(['constructor', 'interval'])],
            'items' => ['required', $this->get('type') === 'constructor'
                ? new ConstructorItemTimerRule
                : new IntervalItemTimerRule
            ]
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'items' => $this->get('type') === 'constructor'
                ? new ConstructorItemTimer($this->get('items'))
                : new IntervalItemTimer($this->get('items'))
        ]);
    }
}
