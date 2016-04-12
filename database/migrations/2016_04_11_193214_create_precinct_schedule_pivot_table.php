<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecinctSchedulePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        array_map(function($value) {        
            Schema::connection($value)->create('precinct_schedule', function($table) {
                $table->integer('precinct_id')->unsigned()->index();
                $table->foreign('precinct_id')->references('id')->on('precincts')->onDelete('cascade');
                $table->integer('schedule_id')->unsigned()->index();
                $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
                $table->primary(['precinct_id', 'schedule_id']);
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
            Schema::connection($value)->drop('precinct_schedule');
        }, array_keys(Config::get('database')['connections']));
    }
}
