<?php

namespace App\Http\Requests;

/**
 * @property mixed from
 * @property mixed to
 * @property mixed requestId
 */
class RequestIdRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'requestId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'requestId.required' => 'Требуется указать requestId'
        ];
    }
}
