<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    protected $guarded = ['id'];
    protected $table = 'car';
}
