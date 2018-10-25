<?php

use Illuminate\Database\Migrations\Migration;

class Olgin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $city = new \App\City;
        $city->name = 'Ольгин';
        $city->iata = 'HOG';
        $city->location = [
            'longitude' => '-76.2594981',
            'latitude' => '20.8795129',
        ];
        $city->save();
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
