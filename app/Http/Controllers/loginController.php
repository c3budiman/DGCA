<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Hash;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

use App\User;

//use Tracker;
class loginController extends Controller
{
  public function __construct()
  {
      $this->middleware('guest');
  }

  //fungsi ini buat login dengan menggunakan email dan password biar dapat api_token
  public function authenticate(Request $request, User $user){
    //dibawah kodingan untuk cek email dan password yg diberikan di header body, apakah match ama yg ada di db atau tidak
    //kalo tidak kita kasih response 401 alias unauthorized
    if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        //return response()->json(['error' => 'Your Credential Is Wrong!! Bitch...'], 401);
        $user = User::where('email',$request->email)->get();
        //generate (time-based) UUID object :
        try {
            $uuid1 = Uuid::uuid5(Uuid::NAMESPACE_DNS, $request->email.date('ymdhms') );
        } catch (UnsatisfiedDependencyException $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        //kalo matching, kita cari id user nya, stor ke variabel user
        $user->api_token = $uuid1->toString();
        $user->save();
        //terakhir kita jadikan response json buat endpoint ke aplikasi yg lain.....
        return response()->json(['get' => $user->api_token], 200);
    }
    else {
      return response()->json(['error' => 'wrong credential'], 401);
    }
    //return 'waw';
    // if (User::where('email',$request->email)->where('password',bcrypt($request->password))->count() > 0) {
    //
    // } else {
    //
    // }
  }

	public function daftarApi(Request $request) {
		$newuser = $request->all();
		$password = Hash::make($request->input('password'));
		$newuser['password'] = $password;
		return User::create($newuser);
	}

  public function getLogin()
  {
    return view('login');
  }
  public function postLogin(Request $request)
  {
    if (Auth::attempt ([
        'email' => $request->email,
        'password' => $request->password,
        'active' => '1'
      ]))
    {
      return redirect('/dashboard')->with('status', 'You have successfully login!');
    }
    else {
      return Redirect::back()->withErrors(['wrong credential / account not active!']);
    }
  }
}
