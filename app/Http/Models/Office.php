<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = "offices";
    public $timestamps = false;
    protected $connection = "central";
    protected $fillable = ['name', 'description'];

    public function users() {
    	return $this->belongsToMany('App\Http\Models\Users', 'office_user', 'office_id', 'user_id');
    }
}
