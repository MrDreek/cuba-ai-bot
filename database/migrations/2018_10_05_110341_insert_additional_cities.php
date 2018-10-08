<?php

use Illuminate\Database\Migrations\Migration;

class InsertAdditionalCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $path = storage_path() . '/app/additional_cities.json';
        $json = json_decode(file_get_contents($path));

        foreach ($json as $item) {
            $city = new \App\City;
            $city->name = $item->name;
            $city->location = $item->location;
            $city->iata = $item->iata;
            $city->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\City::truncate();
        $path = storage_path() . '/app/cities.json';
        $json = json_decode(file_get_contents($path));

        foreach ($json as $key => $item) {
            $city = new \App\City;
            $city->name = $item->name;

            if (isset($item->location)) {
                $city->location = $item->location;
            }

            $city->iata = $key;
            $city->save();
        }
    }
}
