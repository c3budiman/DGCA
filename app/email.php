<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class email extends Model
{
    protected $table = 'known_email';
    public $timestamps = false;
    protected $fillable = ['email'];
}
