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
use App\Perusahaan;


class regisController extends Controller
{
  public function __construct()
  {
      $this->middleware('guest');
  }

  public function getRegisPerusahaan() {
    return view('registrasi.perusahaan');
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
        $user->company = 4;
      }
      $user->save();

      $status = DB::table('user_step')->insert(
        ['user_id'=> $user->id, 'kode_status' => '1','status' => DB::table('status_list')->where('kode_status','1')->first()->keterangan]
      );

      //send verification email :
      Mail::send('emails.register', ['user' => $user], function ($m) use ($user) {
          $m->to($user->email, $user->name)->subject('Konfirmasi Email');
      });

      if ($status) {
        //redirect with message sukses :
        return Redirect::back()->with('status', 'Kamu berhasil mendaftar, Silahkan cek email untuk konfirmasi pendaftaran!');
      } else {
        return Redirect::back()->withErrors(['Terdapat kesalahan saat mendaftar, silahkan coba lagi nanti']);
      }
    }
  }

  public function postDaftarPerusahaan()
  {
    //this one will be useless once an account has been created....
    $emailexist = DB::table('users')->where('email','=',Input::get('email'))->first();
    if (Input::get('email') == null || Input::get('nama') == null || Input::get('password') == null) {
      return Redirect::back()->withErrors( ['No empty field plz!'] );
    }

    if (!empty($emailexist)) {
      return Redirect::back()->withErrors(['Email has been used!']);
    }
    else {
      //insert to perusahaan db :
      $perusahaan                  = new Perusahaan;
      $perusahaan->nama_perusahaan = strip_tags(Input::get('company'));
      $perusahaan->save();

      //register the user to db :
      $user               = new User();
      $user->email        = strip_tags(Input::get('email'));
      $user->nama         = strip_tags(Input::get('nama'));
      $user->avatar       = "/gambar/avatar.png";
      $user->password     = bcrypt(Input::get('password'));
      $user->active       = 0;
      $user->verif_token  = md5(strip_tags(Input::get('email')));
      $user->roles_id     = 4;
      $user->company      = $perusahaan->id;
      $user->save();

      //send verification email :
      Mail::send('emails.register', ['user' => $user], function ($m) use ($user) {
          $m->to($user->email, $user->name)->subject('Konfirmasi Email');
      });

      return Redirect::back()->with('status', 'Kamu berhasil mendaftarkan perusahaan, Silahkan cek email untuk konfirmasi pendaftaran!');
    }
  }

  public function doverif($token) {
    if (DB::table('users')->where('verif_token',$token)->count() > 0) {
      $user_roles = DB::table('users')->where('verif_token',$token)->first()->roles_id;
      $user_id    = DB::table('users')->where('verif_token',$token)->first()->id;

      if ($user_roles == 3) {
        $status = DB::table('user_step')->where('user_id',$user_id)->update(
          ['kode_status' => '2','status' => DB::table('status_list')->where('kode_status','2')->first()->keterangan]
        );
      }

      $user = DB::table('users')->where('verif_token',$token)->update(
        ['active' => '1','verif_token' => '']
      );

      if ($user) {
        return redirect('login')->with('status', 'Selamat, akun mu telah terverifikasi, Kamu dapat login.');
      } else {
        return redirect('login')->withErrors(['Terdapat kesalahan saat verifikasi, silahkan coba lagi nanti']);
      }
    } else {
      return redirect('login')->withErrors(['Email sudah terverifikasi']);
    }
  }
}
