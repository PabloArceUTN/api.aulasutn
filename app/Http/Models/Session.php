<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
  protected $table = "sessions";
  public $timestamps = false;
  protected $connection = "central";
  protected $fillable = ['token', 'expires', 'active'];

  public function users() {
    //  Param #1 Model to, Param #2 table on the DB, Param #3 first column, Param #4 second column
    return $this->belongsToMany('App\Http\Models\Users', 'users_sessions', 'session_id','user_id');
  }
}
