<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed from
 * @property mixed to
 */
class RequestIdRequest extends FormRequest
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
            'requestId' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'requestId.required' => 'Требуется указать requestId',
            'requestId.integer' => 'requestId должен быть числом',
        ];
    }
}
