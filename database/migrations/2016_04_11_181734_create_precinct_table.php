<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecinctTable extends Migration
{
    protected $connection;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        array_map(function($value) {        
            Schema::connection($value)->create('precincts', function($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('address');
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
            Schema::connection($value)->drop('precincts');
        }, array_keys(Config::get('database')['connections']));
    }
}
