<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserSessionTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('users_sessions', function (Blueprint $table) {
      $table->integer('user_id')->unsigned()->index();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->integer('session_id')->unsigned()->index();
      $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
      $table->primary(['user_id', 'session_id']);
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::drop('users_sessions');
  }
}
