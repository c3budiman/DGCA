<?php

namespace App;
use App\Sidebar;

use Illuminate\Database\Eloquent\Model;

class submenu extends Model
{
  protected $table = 'submenu';
  public $timestamps = false;

  public function sidebar()
  {
    return $this->belongsTo(Sidebar::class,'roles_id');
  }
}
