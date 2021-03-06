<?php

namespace App\Http\Requests;

use App\Rules\CustomDate;

/**
 * @property mixed AD
 * @property mixed CN
 * @property mixed IN
 */
class TicketRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'departure_date' => ['required', new CustomDate(request()->field, request()->another_field)],
            'return_date' => ['nullable', new CustomDate(request()->field, request()->another_field)],
            'AD' => 'integer|min:1|max:6',
            'CN' => 'integer|min:0|max:4',
            'IN' => 'integer|min:0|max:2',
            'SC' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'departure_city.required' => 'Необходимо указать город отправленя',
            'arrival_city.required' => 'Необходимо указать город прибытия',
            'departure_date.required' => 'Необходимо указать дату отправления',
            'departure_date.date' => 'departure_date - должно быть датой',
            'return_date.date' => 'return_date - должно быть датой',
            'AD.required' => 'Необходимо указать количество взрослых',
            'AD.integer' => 'Количество взрослых должно быть числом',
            'AD.min' => 'Количество взрослых должно быть больше 1',
            'AD.max' => 'Количество взрослых должно быть меньше 6',
            'CN.integer' => 'Количество детей с 2х до 12ти лет должно быть числом',
            'CN.min' => 'Количество детей с 2х до 12ти лет должно быть больше 0',
            'CN.max' => 'Количество детей с 2х до 12ти лет должно быть меньше 4',
            'IN.integer' => 'Количество детей с 2х до 12ти лет должно быть числом',
            'IN.min' => 'Количество детей с 2х недель до 2х лет должно быть больше 0',
            'IN.max' => 'Количество детей с 2х недель до 2х лет должно быть меньше 2',
        ];
    }
}
