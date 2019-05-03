<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\role;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Transformers\UserTransformer;
use Auth;
class regisController extends Controller
{
  public function __construct()
  {
      $this->middleware('guest');
  }
  public function getRegis()
  {
    return view('daftar');
  }
  public function postRegis()
  {
    //this one will be useless once an account has been created....
    $emailexist = DB::table('users')->where('email','=',Input::get('email'))->first();
    if (Input::get('email') == null || Input::get('nama') == null || Input::get('password') == null) {
      return Redirect::back()->withErrors(['No empty field plz!']);
    }
    if (!empty($emailexist)) {
      return Redirect::back()->withErrors(['Email has been used!']);
    } else {
      $user = new User();
      $user->email = strip_tags(Input::get('email'));
      $user->nama = strip_tags(Input::get('nama'));
      $user->avatar = strip_tags(Input::get('avatar'));
      $user->password = bcrypt(Input::get('password'));
      $user->roles_id = 1;
      $user->save();
      return redirect('/')->with('status', 'You have successfuly registered!');
    }
  }
}
