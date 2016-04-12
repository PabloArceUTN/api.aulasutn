<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = "schedules";
    public $timestamps = false;
    protected $fillable = ['name', 'start', 'finish'];

    public function precints() {
        return $this->belongsToMany('App\Http\Models\Precinct', 'precinct_schedule', 'schedule_id', 'precinct_id');
    }
}
