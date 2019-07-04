<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class applicantController extends Controller
{
    //get role admin : u can change 1 or 2 to id of the admin id that use this controller
    public function getRolePengguna() {
      $rolesyangberhak = DB::table('roles')->where('id','=','3')->first()->namaRule;
      return $rolesyangberhak;
    }

    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('rule:'.$this->getRolePengguna().','.'nothingelse');
    }

    public function getIdentitas() {
      return view('applicant.identitas');
    }
}
