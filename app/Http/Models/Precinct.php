<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Precinct extends Model
{
    protected $table = "precincts";
    public $timestamps = false;
    protected $fillable = ['name', 'address'];

    public function schedules() {
        return $this->belongsToMany('App\Http\Models\Schedule', 'precinct_schedule', 'precinct_id', 'schedule_id');
    }
}
