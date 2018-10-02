<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed from
 * @property mixed to
 */
class MoneyRateRequest extends FormRequest
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
        return [
            'from' => 'required',
            'to' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'from.required' => 'Требуется указать из какой валюты нужно произвести конвертацию',
            'to.required' => 'Требуется указать в какую валюту нужно произвести конвертацию',
        ];
    }
}
