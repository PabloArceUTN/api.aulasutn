<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = "careers";
    public $timestamps = false;
    protected $connection = "central";
    protected $fillable = ['code', 'name'];
}
