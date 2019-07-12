<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use Excel;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\SettingSitus;
use Storage;
use App\berita;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

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

    //get isi identitas :
    public function getIdentitas() {
      return view('applicant.identitas');
    }

    //isi identitas :
    public function postIdentitas(Request $request) {
      $address = '';
      $address .= 'Desa, '.DB::table('villages')->where('id',$request->village)->first()->name;
      $address .= ' Kabupaten, '.DB::table('regencies')->where('id',$request->regency)->first()->name;
      $address .= ' Kecamatan, '.DB::table('districts')->where('id',$request->district)->first()->name;
      $address .= ' Provinsi, '.DB::table('provinces')->where('id',$request->provinsi)->first()->name;

      $user = User::find(Auth::User()->id);
      $user->nama         = $request->nama;
      $user->company      = $request->company;
      $user->nama         = $request->nama;
      $user->phone        = $request->phone;
      $user->address      = $address;
      //todo : upload foto dokumen dan save.
      $user->save();

      $status = DB::table('user_step')->where('user_id',$user->id)->update(
        ['kode_status' => '3','status' => DB::table('status_list')->where('kode_status','3')->first()->keterangan]
      );

      return redirect('dashboard')->with('status', 'Kamu berhasil mendaftarkan identitas, Silahkan tambahkan drone yang akan di terbangkan di menu Drone!');
    }

    //get isi identitas :
    public function getDrones() {
      return view('applicant.drones');
    }


}
