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
use Intervention\Image\ImageManagerStatic as Image;


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

    public function uploadIdentitas(Request $request) {
      $file = $request->file('upload_doc');
      $user = User::find(Auth::User()->id);

      if ($file) {
          $tujuan_upload = public_path().'/dokumen/ktp/'.Auth::User()->id;
          $nama_file = 'FotoIdentitas_'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
          //upload :
          if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
            //store the fotoktp :
            $stored = [
              'original'    => url('/').'/foto/'.Auth::User()->id.'/'.$nama_file,
              'resized'     => url('/').'/foto/'.Auth::User()->id.'/Resized'.$nama_file,
              'thumbnail'   => url('/').'/foto/'.Auth::User()->id.'/Thumbnail'.$nama_file
            ];
            $user->dokumen_identitas = json_encode($stored);
            $user->save();

            //Success :
            return response()->json(['Success' => true, 'data' => $stored], 200);
          } else {
            $error = ['fotoktp' => 'fail because of not an image file!'];
            return response()->json(['Success' => false, 'error' => $error], 401);
          }
      } else {
        // upload fail because the file is not exist / request is half way through
        $error = ['fotoktp' => 'upload fail!'];
        return response()->json(['Success' => false, 'error' => $error], 401);
      }
    }

    //isi identitas :
    public function postIdentitas(Request $request) {
      $user          = User::find(Auth::User()->id);

      $address = '';
      $address .= DB::table('villages')->where('id',$request->village)->first()->name;
      $address .= ', '.DB::table('regencies')->where('id',$request->regency)->first()->name;
      $address .= ', '.DB::table('districts')->where('id',$request->district)->first()->name;
      $address .= ', '.DB::table('provinces')->where('id',$request->provinsi)->first()->name;

      if ($user->dokumen_identitas) {
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
      } else {
        return Redirect::back()->withErrors(['Silahkan Upload Foto Identitas!']);
      }

    }

    //get isi identitas :
    public function getDrones() {
      return view('applicant.drones');
    }

    public function uploadDokumenUAS(Request $request) {
      $file = $request->file($request->nameofFile);
      $user = User::find(Auth::User()->id);

      if ($file) {
          $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
          $nama_file = $request->nameofFile.'_'.Auth::User()->id.'.'.$file->getClientOriginalExtension();

          //upload :
          if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
            //store the fotoktp :
            $stored = [
              'original'    => url('/').'/foto/'.Auth::User()->id.'/'.$nama_file,
              'resized'     => url('/').'/foto/'.Auth::User()->id.'/Resized'.$nama_file,
              'thumbnail'   => url('/').'/foto/'.Auth::User()->id.'/Thumbnail'.$nama_file
            ];
            $user->dokumen_identitas = json_encode($stored);
            $user->save();

            //Success :
            return response()->json(['Success' => true, 'data' => $stored], 200);
          } else {
            $error = ['fotoktp' => 'fail because of not an image file!'];
            return response()->json(['Success' => false, 'error' => $error], 401);
          }
      } else {
        // upload fail because the file is not exist / request is half way through
        $error = ['fotoktp' => 'upload fail!'];
        return response()->json(['Success' => false, 'error' => $error], 401);
      }

    }

    public function postDrones(Request $request) {
      dd($request->all());
    }

    protected function uploadImage($file, $tujuan_upload, $nama_file) {
      if (substr($file->getMimeType(), 0, 5) == 'image') {

        //make the folder :
        if (!is_dir($tujuan_upload)) {
            mkdir($tujuan_upload, 0777, true);
        }

        //make thumbnail :
        $img = Image::make($file->getRealPath());
        $img->resize(100, 100, function ($constraint) {
    		    $constraint->aspectRatio();
    		})->orientate()->save($tujuan_upload.'/'.'Thumbnail'.$nama_file);

        //resized image :
        $img = Image::make($file->getRealPath());
        $img->resize(600, 800, function ($constraint) {
    		    $constraint->aspectRatio();
    		})->orientate()->save($tujuan_upload.'/'.'Resized'.$nama_file);

        //store the real photo :
        if (file_exists($tujuan_upload.$nama_file)) {
          unlink($tujuan_upload.$nama_file);
          $file->move($tujuan_upload,$nama_file);
        } else {
          $file->move($tujuan_upload,$nama_file);
        }

        return true;
      } else {
        // upload fail because it is not an image.
        return false;
      }
    }

}
