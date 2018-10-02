<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'city' => 'required|integer',
            'date_end' => 'date',
        ];
    }

    public function messages()
    {
        return [
            'city.required' => 'Требуется указать код города',
            'city.integer' => 'Код должен быть числом',
            'date_end.date' => 'date_end должен быть Date',
        ];
    }
}
