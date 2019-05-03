<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Redirect;
class loginController extends Controller
{
  public function __construct()
  {
      $this->middleware('guest');
  }
  public function getLogin()
  {
    return view('login');
  }
  public function postLogin(Request $request)
  {
    if (Auth::attempt ([
        'email' => $request->email,
        'password' => $request->password
      ]))
    {
      return redirect('/dashboard')->with('status', 'You have successfully login!');
    }
    else {
      return Redirect::back()->withErrors(['wrong credential!']);
    }
  }
}
