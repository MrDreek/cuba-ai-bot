<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDirectory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $path = storage_path() . '/app/directories.json';
        $json = json_decode(file_get_contents($path), true);

        foreach ($json[0] as $type => $directory) {
            foreach ($directory as $key => $item) {
                $dir = new \App\Directory();
                $dir->type = $type;
                $dir->key = $key;
                $dir->value = $item;
                $dir->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Directory::truncate();
    }
}
