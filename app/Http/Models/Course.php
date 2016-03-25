<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "courses";
    public $timestamps = false;
    protected $connection = "central";
    protected $fillable = ['code', 'name'];
}
