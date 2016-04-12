<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        array_map(function($value) {        
            Schema::connection($value)->create('periods', function($table) {
                $table->increments('id');
                $table->string('name');
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
            Schema::connection($value)->drop('periods');
        }, array_keys(Config::get('database')['connections']));
    }
}
