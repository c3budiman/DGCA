<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Redirect;
use File;
use Storage;
use User;
use App\Sidebar;
use Excel;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;


class authController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
  public function logout() {
    Auth::logout();
    return redirect('/login')->with('status', 'You have successfully logout!');
  }
  public function getRoot() {
    $roles_id = Auth::User()->roles_id;
    switch ($roles_id) {
      case 1:
        return view('dashboard.DashSuperAdmin');
        break;
      case 2:
        return view('dashboard.DashAdmin');
        break;
      case 3:
        return view('dashboard.DashUser');
        break;
      case 4:
        return view('dashboard.DashAdminPerusahaan');
        break;
      default:
        return view('dashboard.DashUser');
        break;
    }
  }
  public function getMyProfile() {
    return view('myProfile');
  }
  public function getEditProfile() {
    return view('editprofile');
  }
  public function getSupport() {
    return view('support');
  }
  public function UpdateProfile(Request $request) {
    if ($request->hasFile('tes')) {
      //change the password here...
      if ($request->password2) {
        $password = $request->password;
        $passwordbaru1 = $request->password1;
        $passwordbaru2 = $request->password2;
        if ($passwordbaru1 == $passwordbaru2) {
                //ganti password here
                $request->user()->fill(['password'=>Hash::make($passwordbaru1)])->save();
          }
          else {
            return Redirect::back()->withErrors(['error', 'Password doesnt match']);
          }
      }

      $namafile = $request->file('tes')->getClientOriginalName();
      $ext = $request->file('tes')->getClientOriginalExtension();
      $newNamaFile = Auth::User()->email .'-id_'. Auth::User()->id . '.' .$ext;
      // yg paling penting cek extension, no php allowed
      if ($ext == "png" || $ext == "jpg" || $ext == "jpeg" || $ext == "PNG" || $ext == "JPG" || $ext == "JPEG") {
        //store
        $destinasi = public_path('../../storage/avatar/');
        //dd($destinasi);
        $proses = $request->file('tes')->move($destinasi,$newNamaFile);
        $lokasifileskr = 'storage/avatar/'.$newNamaFile;
        //update db
        $users = Auth::user();
        $users->email = strip_tags(Input::get('email'));
        $users->nama = strip_tags(Input::get('nama'));
        $users->avatar = $lokasifileskr;
        $users->save();
        return redirect('editprofile')->with('status', 'Your profile has been updated!');
      } else {
        return Redirect::back()->withErrors(['file format error']);
      }
    } else {
      //change the password here...
      if ($request->password2) {
        $password = $request->password;
        $passwordbaru1 = $request->password1;
        $passwordbaru2 = $request->password2;
        if ($passwordbaru1 == $passwordbaru2) {
                //ganti password here
                $request->user()->fill(['password'=>Hash::make($passwordbaru1)])->save();
          }
          else {
            return Redirect::back()->withErrors(['error', 'Password doesnt match']);
          }
      }
      //update db without poto profile
      //update db
      $users = Auth::user();
      $users->email = strip_tags(Input::get('email'));
      $users->nama = strip_tags(Input::get('nama'));
      $users->save();
      return redirect('editprofile')->with('status', 'Your profile has been updated!');
    }
  }

  public function getAturIndex() {
    return view('pages.index');
  }

  public function getAturFiles() {
    return view('files');
  }

  public function getAturPhotos() {
    return view('photos');
  }

  public function getCars() {
    return view('auto.car');
  }

}
