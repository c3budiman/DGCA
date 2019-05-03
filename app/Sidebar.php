<?php

namespace App;
use App\submenu;

use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    protected $table = 'dashmenu';
    public $timestamps = false;

    public function submenu()
    {
      return $this->hasMany(submenu::class);
    }
}
