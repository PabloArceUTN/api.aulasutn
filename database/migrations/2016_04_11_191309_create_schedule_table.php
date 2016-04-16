<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        array_map(function($value) {        
            Schema::connection($value)->create('schedules', function($table) {
                $table->increments('id');
                $table->string('name');
                $table->time('start');
                $table->time('finish');
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
            Schema::connection($value)->drop('schedules');
        }, array_keys(Config::get('database')['connections']));
    }
}
