<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gallery extends Model
{
    protected $guarded = ['id'];
    protected $table = 'gallery';
}
