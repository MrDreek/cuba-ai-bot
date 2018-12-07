<?php

namespace App\Http\Requests;

class TourRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_city' => 'required|exists:cities_collection,name',
            'to_city' => 'string|exists:cities_collection,name',
            'hotel_ids' => 'string',
            'nights' => 'required|integer',
            'adults' => 'required|integer',
            'start_date' => 'required|dateformat:d.m.Y',
            'kids' => 'integer',
            'kids_ages' => 'required_with:kids|string',
            'stars_from' => 'integer|min:1|max:5',
            'stars_to' => 'integer|min:1|max:5',
        ];
    }

    public function messages()
    {
        return [
            'from_city.required' => 'Необходимо указать город вылета',
            'from_city.exists' => 'Такой горорд не найден',
            'to_city.required' => 'Город назначения должен быть строкой',
            'to_city.exists' => 'Такой горорд не найден',
            'hotel_ids.required' => 'Id отлелей должны быть перечислены через запятую',
            'nights.required' => 'Необходимо указать количетсво ночей',
            'nights.integer' => 'Количество ночей должно быть числом',
            'adults.required' => 'Необходимо указать количетсво взрослых',
            'adults.integer' => 'Количество вхрослых должно быть числом',
            'start_date.required' => 'Необходимо указать дату начала',
            'start_date.dateformat' => 'Дата начала должна быть в формате DD.MM.YYYY',
            'kids.integer' => 'Количество детей должглбыть числом',
            'kids_ages.string' => 'Возраст детей необходимо записать через запятую и это должно быть строкой',
            'kids_ages.required_if' => 'Необходимо указать возраст детей, если количество детей не пусто',
            'stars_from.min' => '"Количество звёсд от" должно быть больше 0',
            'stars_from.max' => '"Количество звёсд от" должно быть меньше 6',
            'stars_from.integer' => '"Количество звёсд от" должно быть числом',
            'stars_to.min' => '"Количество звёсд до" должно быть больше 0',
            'stars_to.max' => '"Количество звёсд до" должно быть меньше 6',
            'stars_to.integer' => '"Количество звёсд до" должно быть числом',
        ];
    }
}
