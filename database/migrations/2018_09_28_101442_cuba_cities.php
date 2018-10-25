<?php

use Illuminate\Database\Migrations\Migration;

class CubaCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\City::truncate();
        $path = storage_path() . '/app/cities.json';
        $json = json_decode(file_get_contents($path));

        foreach ($json as $key => $item) {
            $city = new \App\City;
            $city->name = $item->name;
            $city->iata = $key;

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
    }
}
