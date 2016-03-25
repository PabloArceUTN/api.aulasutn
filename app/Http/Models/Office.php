<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = "offices";
    public $timestamps = false;
    protected $connection = "central";
    protected $fillable = ['name', 'description'];
}
