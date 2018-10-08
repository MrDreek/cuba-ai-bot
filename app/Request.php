<?php

namespace App;

use DateTime;

/**
 * @property int|string requestId
 * @property mixed status
 * @property DateTime departureDate
 * @property DateTime returnDate
 * @property mixed link
 * @property array|mixed tickets
 * @method static where(string $string, string $param)
 */
class Request extends BaseModel
{
    protected $collection = 'requests_collection';

    public const INIT_URL = '${host}/api/NewRequest/?Route=${to}${from}&AD=${AD}&CN=${CN}&IN=${IN}&SC=${SC}&Partner=${code}';
    public const DETAIL_URL = '${host}/api/RequestInfo/?R=${request_id}';
    public const STATUS_URL = '${host}/api/RequestState/?R=${request_id}';
    public const RESULT_URL = '${host}/api/Fares/?R=${request_id}';

    private const SC = [
        'эконом' => 'E',
        'бизнес/первый класс' => 'B'
    ];

    public static function createRequest($request)
    {
        $departureDate = new DateTime($request->departure_date);
        $departureDate_day = $departureDate->format('d');
        $departureDate_month = $departureDate->format('m');

        $iataDepartureCity = City::where('name', $request->departure_city)->firstOrFail()->iata;
        $iataArrivalCity = City::where('name', $request->arrival_city)->firstOrFail()->iata;

        $to = $departureDate_day . $departureDate_month . $iataDepartureCity . $iataArrivalCity;
        $from = '';

        if ($request->return_date !== null) {
            $returnDate = new DateTime($request->return_date);
            $returnDate_day = $returnDate->format('d');
            $returnDate_month = $returnDate->format('m');

            $from = $returnDate_day . $returnDate_month . $iataArrivalCity . $iataDepartureCity;
        }

        $AD = $request->AD ?: 1;
        $CN = $request->CN ?: 0;
        $IN = $request->IN ?: 0;


        $SC = self::SC['эконом'];
        if (($request->SC !== null) && $request->SC === 'бизнес/первый') {
            $SC = self::SC[$request->SC];
        }

        $host = config('app.awad_host');
        $key = config('app.awad_key');

        $url = str_replace(['${host}', '${to}', '${from}', '${AD}', '${CN}', '${IN}', '${SC}', '${code}'], [$host, $to, $from, $AD, $CN, $IN, $SC, $key], self::INIT_URL);

        $requestId = self::xmlGet($url)->{'@attributes'};// xml зло!

        if (!isset($requestId->Error)) {
            $myRequest = new self;
            $myRequest->requestId = $requestId->Id;
            $myRequest->departureDate = $request->departure_date;
            $myRequest->returnDate = $request->return_date;
            $myRequest->save();
            return ['requestId' => $requestId->Id];
        }
        return ['error' => $requestId->Error];
    }

    public function check()
    {
        $host = config('app.awad_host');
        $url = str_replace(['${host}', '${request_id}'], [$host, $this->requestId], self::STATUS_URL);

        $message = 'Готов к получению результатов';

        if ($this->status !== '100') {
            $status = self::xmlGet($url)->{'@attributes'};// xml зло!

            $this->status = $status->Completed;
            $this->save();

            if ($this->status !== '100') {
                $message = 'Результат ещё не готов!';
            }
        }

        return ['percentage' => $this->status, 'message' => $message];
    }

    public function getResult()
    {
        $host = config('app.awad_host');
        $url = str_replace(['${host}', '${request_id}'], [$host, $this->requestId], self::RESULT_URL);

        $results = self::xmlGet($url);// xml зло!

        if(isset($results->{'@attributes'}->Error))
        {
            return false;
        }

        $this->link = $results->SearchRequestURL;
        $tickets = [];

        $airlines = [];
        foreach ($results->Referenses->Airline as $item) {
            if(isset($item->{'@attributes'})){
                $airlines[$item->{'@attributes'}->C] = $item->{'@attributes'}->N;
            } else {
                $airlines[$item->C] = $item->N;
            }
        }

        foreach ($results->F as $item) {
            $arrTo = [];
            if (!isset($item->L->V->{'@attributes'})) {
                foreach ($item->L->V as $l) {
                    $arrTo[] = [
                        'department_time' => $l->{'@attributes'}->DT,
                        'department_date' => $this->departureDate,
                        'flight_time' => $l->{'@attributes'}->TT,
                        'route' => $l->{'@attributes'}->SA
                    ];
                }
            } else {
                $arrTo[] = [
                    'department_time' => $item->L->V->{'@attributes'}->DT,
                    'department_date' => $this->departureDate,
                    'flight_time' => $item->L->V->{'@attributes'}->TT,
                    'route' => $item->L->V->{'@attributes'}->SA
                ];
            }


            $arrFrom = [];
            if (!isset($item->R->V->{'@attributes'})) {
                foreach ($item->R->V as $r) {
                    $arrFrom[] = [
                        'department_time' => $r->{'@attributes'}->DT,
                        'department_date' => $this->returnDate,
                        'flight_time' => $r->{'@attributes'}->TT,
                        'route' => $r->{'@attributes'}->SA
                    ];
                }
            } else {
                $arrFrom[] = [
                    'department_time' => $item->R->V->{'@attributes'}->DT,
                    'department_date' => $this->departureDate,
                    'flight_time' => $item->R->V->{'@attributes'}->TT,
                    'route' => $item->R->V->{'@attributes'}->SA
                ];
            }

            foreach ($arrTo as $to) {
                foreach ($arrFrom as $from) {
                    $ticket = new Ticket;
                    $ticket->requestId = $this->requestId;
                    $ticket->AC = $airlines[$item->{'@attributes'}->AC];
                    $ticket->AT = $item->{'@attributes'}->AT;
                    $ticket->to = $to;
                    $ticket->from = $from;
                    $ticket->save();
                    $tickets[] = $ticket;
                }
            }
        }

        $this->tickets = $tickets;
        $this->save();

        return true;
    }
}
