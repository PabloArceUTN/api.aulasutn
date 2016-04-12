<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = "precincts";
    public $timestamps = false;
    protected $fillable = ['name', 'start', 'finish'];
}
