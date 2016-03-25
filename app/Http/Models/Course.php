<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "courses";
    public $timestamps = false;
    protected $connection = "central";
    protected $fillable = ['code', 'name'];

    public function users() {
    	return $this->belongsToMany('App\Http\Models\Users', 'course_user', 'course_id', 'user_id');
    }

    public function careers() {
    	return $this->belongsToMany('App\Http\Models\Career', 'career_course', 'career_id', 'course_id');
    }
}
