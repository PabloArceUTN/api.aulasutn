<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = "careers";
    public $timestamps = false;
    protected $connection = "central";
    protected $fillable = ['code', 'name'];

    public function users() {
    	return $this->belongsToMany('App\Http\Models\Users', 'career_user', 'career_id', 'user_id');
    }

    public function courses() {
    	return $this->belongsToMany('App\Http\Models\Course', 'career_course', 'career_id', 'course_id');
    }
}
