<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        array_map(function($value) {        
            Schema::connection($value)->create('events', function($table) {
                $table->increments('id');
                $table->string('description');
                $table->date('start');
                $table->date('finish');
            });
        }, array_keys(Config::get('database')['connections']));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        array_map(function($value) {
            Schema::connection($value)->drop('events');
        }, array_keys(Config::get('database')['connections']));
    }
}
