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
use Mail;


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

  public function doverif($token) {
    if (DB::table('users')->where('verif_token',$token)->count() > 0) {
      $user = DB::table('users')->where('verif_token',$token)->update(
        ['active' => '1','verif_token' => '']
      );
      if ($user) {
        return redirect('login')->with('status', 'Selamat, akun mu telah terverifikasi, Kamu dapat login.');
      } else {
        return redirect('login')->withErrors(['Terdapat kesalahan saat verifikasi, silahkan coba lagi nanti']);
      }
    } else {
      return redirect('register')->withErrors(['Invalid Verfication Token!']);
    }
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
      //register the user to db :
      $user = new User();
      $user->email = strip_tags(Input::get('email'));
      $user->nama = strip_tags(Input::get('nama'));
      $user->avatar = "/gambar/avatar.png";
      $user->password = bcrypt(Input::get('password'));
      $user->active = 0;
      $user->verif_token = md5(strip_tags(Input::get('email')));
      $user->roles_id = 3;
      if (Input::get('tipe') == 'bisnis') {
        $user->company = Input::get('perusahaan');
      } else {
        $user->company = 'n/a';
      }
      $user->save();

      //send verification email :
      Mail::send('emails.register', ['user' => $user], function ($m) use ($user) {
          $m->to($user->email, $user->name)->subject('Konfirmasi Email');
      });

      //redirect with message sukses :
      return Redirect::back()->with('status', 'Kamu berhasil mendaftar, Silahkan cek email untuk konfirmasi pendaftaran!');
    }
  }
}
