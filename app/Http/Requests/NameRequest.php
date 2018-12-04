<?php

namespace App\Http\Requests;

/**
 * @property mixed name
 */
class NameRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|exists:cities_collection,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Требуется указать название города',
            'name.exists' => 'Город не найден',
        ];
    }
}
