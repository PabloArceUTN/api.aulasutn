<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    public $timestamps = false;
    protected $connection = "central";
    protected $fillable = ['email', 'password', 'name', 'phone_number', 'admin', 'teacher', 'active'];

    public function offices() {
    	return $this->belongsToMany('App\Http\Models\Office', 'office_user', 'user_id', 'office_id');
    }

    public function courses() {
    	return $this->belongsToMany('App\Http\Models\Course', 'course_user', 'course_id', 'user_id');
    }

    public function careers() {
    	return $this->belongsToMany('App\Http\Models\Career', 'career_user', 'career_id', 'user_id');
    }
}
