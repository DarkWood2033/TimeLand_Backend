<?php

namespace App\Http\Requests\Support;

use Illuminate\Foundation\Http\FormRequest;

class SupportRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(auth()->check()){

            return [
                'subject' => 'required|string|min:5|max:255',
                'message' => 'required|string|min:25|max:500'
            ];
        }
        return [
            'name' => 'required|string|min:2|max:32',
            'email' => 'required|email',
            'subject' => 'required|string|min:5|max:255',
            'message' => 'required|string|min:25|max:500'
        ];
    }
}
