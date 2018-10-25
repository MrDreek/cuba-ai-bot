<?php

use Illuminate\Database\Migrations\Migration;

class CubaCityInsert extends Migration
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
            $city = \App\City::where('name', $item->name)->first();
            if($city === null)
            {
                $city = new \App\City;
                $city->name = $item->name;
                $city->iata = $item->iata;
            }
            $city->location = $item->location;
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
        //
    }
}
