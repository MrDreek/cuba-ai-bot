<?php

namespace App;

/**
 * @property  mixed request_id
 */
class Tour extends BaseModel
{
    protected $collection = 'tour_collection';

    private const START_SEARCH_URL = 'https://api.level.travel/search/enqueue?';
    private const CHECK_URL = 'https://api.level.travel/search/status?request_id=';
    private const GET_RESULTS_URL = 'https://api.level.travel/search/get_grouped_hotels?request_id=';

    private const LEVEL_TRAVEL_DOMAIN = 'https://level.travel';

    private const TO_CONTRY = 'to_country=CU';

    private const FOOD = [
        'OB' => 'Без питания',
        'BB' => 'Завтрак',
        'HB' => 'Полупансион',
        'FB' => 'Полный пансион',
        'AI' => 'Всё включено',
        'RO' => 'Без питания',
    ];

    public static function startSearch($params)
    {
        $url = self::START_SEARCH_URL . self::TO_CONTRY;

        $from_city = City::where('name_ru', $params['from_city'])->firstOrFail()->iata;
        $url .= "&from_city=$from_city";
        unset($params['from_city']);

        if (isset($params['to_city'])) {
            $to_city = City::where('name_ru', $params['to_city'])->firstOrFail()->iata;
            $url .= "&to_city=$to_city";
            unset($params['to_city']);
        }

        foreach ($params as $key => $item) {
            $url .= '&' . $key . '=' . $item;
        }

        $response = self::curlToWithTourHeaders($url);

        $tour = new self;
        $tour->request_id = $response->request_id;

        if (!$tour->save()) {
            return ['message' => 'Ошибка сохранения тура', 'code' => 500];
        }

        return $tour->request_id;
    }

    public function checkStatus()
    {
        $url = self::CHECK_URL . $this->request_id;
        $response = self::curlToWithTourHeaders($url);

        if ($response->success) {
            foreach ($response->status as $status) {
                if ($status === 'completed' || $status === 'cached' || $status === 'all_filtered') {
                    return ['message' => 'Результат готов!', 'code' => 200];
                }
            }

            return ['message' => 'Ничего не найдено', 'code' => 204];
        }

        return ['message' => 'Внутренняя ошибка сервера', 'error' => $response->error];
    }

    public function getResults()
    {
        $url = self::GET_RESULTS_URL . $this->request_id;
        $response = self::curlToWithTourHeaders($url);

        if (isset($response->hotels)) {
            if (empty($response->hotels)) {
                $r = [
                    'code' => 204,
                    'message' => 'Ничего не найдено!'
                ];

                return $r;
            }

            $hotels = [];
            foreach ($response->hotels as $hotel) {
                $food = [];

                foreach ($hotel->pansion_prices as $key => $pansion_price) {
                    $food[$key] = $key . '(' . self::FOOD[$key] . ')';
                }

                $hotels[] = [
                    'name' => $hotel->hotel->name,
                    'desc' => $hotel->hotel->desc,
                    'city' => $hotel->hotel->city,
                    'stars' => $hotel->hotel->stars,
                    'min_price' => $hotel->min_price,
                    'max_price' => $hotel->max_price,
                    'food' => implode(', ', $food),
                    'link' => self::LEVEL_TRAVEL_DOMAIN . $hotel->hotel->link
                ];
            }

            $r = [
                'code' => 200,
                'results' => $hotels
            ];

            return $r;
        }
        return ['error' => $response->error, 'code' => 500];
    }
}
