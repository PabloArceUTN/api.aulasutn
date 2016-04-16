<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = "classrooms";
    public $timestamps = false;
    protected $fillable = ['code', 'precinct_id', 'description', 'observation'];

    public function precint() {
        return $this->belongsTo('App\Http\Models\Precinct');
    }
}
