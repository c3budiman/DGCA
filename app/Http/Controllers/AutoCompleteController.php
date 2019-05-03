<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\email;

class AutoCompleteController extends Controller
{
  public function searchFunction(Request $request){
      return email::where('email', 'like', '%'.$request->search.'%')->get();
  }
  public function searchUsers(Request $request)
  {
      return email::where('email', 'like', '%'.$request->q.'%')->get();
  }

}
