<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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
        $path = storage_path() . '/app/cities.json';
        $json = json_decode(file_get_contents($path), true);

        foreach ($json as $item) {
            $city =  new \App\City;
            $city->name = $item['name'];
            $city->nameRus = $item['nameRus'];
            $city->location = $item['location'];
            $city->airport = $item['airport'];
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
