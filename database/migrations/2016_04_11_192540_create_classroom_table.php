<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        array_map(function($value) {        
            Schema::connection($value)->create('classrooms', function($table) {
                $table->increments('id');
                $table->string('code');
                $table->integer('precinct_id')->unsigned()->index();
                $table->string('description');
                $table->string('observation');
                $table->foreign('precinct_id')->references('id')->on('precincts')->onDelete('cascade');
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
            Schema::connection($value)->drop('classrooms');
        }, array_keys(Config::get('database')['connections']));
    }
}
