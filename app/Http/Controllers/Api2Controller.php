<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class Api2Controller extends Controller
{
  public function tesadmin(User $user, Request $request) {
    $user = User::where('api_token', $request->api_token)->first();
    return response()->json(['user' => $user], 200);
  }

  public function tesadmin2(User $user, Request $request) {
    $user = User::where('api_token', $request->api_token)->first();
    return response()->json(['user' => $user], 200);
  }
}
