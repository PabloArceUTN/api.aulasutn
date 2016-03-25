<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    public $timestamps = false;
    protected $connection = "central";
    protected $fillable = ['email', 'password', 'name', 'phone_number', 'admin', 'teacher', 'active'];
}
