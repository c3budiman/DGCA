<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Perusahaan;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;

class AdminPerusahaanController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('rule:'.$this->getRolePengguna().','.'nothingelse');
    }

    public function getRolePengguna() {
      $rolesyangberhak = DB::table('roles')->where('id','=','4')->first()->namaRule;
      return $rolesyangberhak;
    }

    public function getIsianPerusahaan()
    {
      return view('perusahaan.IsianPerusahaan');
    }

    public function UploadDokumenPerusahaan(Request $request) {
      //dd($request->all());
      $file          = null;
      $user          = User::find(Auth::User()->id);
      $perusahaan    = Perusahaan::find($user->company);
      $tujuan_upload = '';
      $nama_file     = '';
      $tipe_upload   = '';
      $stored        = array();
      $random        = $this->generateRandomString();

      if ($request->dokumen_ktp_penanggung) {
        $file = $request->file('dokumen_ktp_penanggung');
        $tujuan_upload = public_path().'/dokumen/perusahaan/ktp/'.$perusahaan->id;
        $nama_file     = 'dokumen_ktp_penanggung'.$perusahaan->id.$random.'.'.$file->getClientOriginalExtension();
        $stored = [
          'original'    => url('/').'/dokumen/perusahaan/ktp/'.$perusahaan->id.'/'.$nama_file,
          'resized'     => url('/').'/dokumen/perusahaan/ktp/'.$perusahaan->id.'/Resized'.$nama_file,
          'thumbnail'   => url('/').'/dokumen/perusahaan/ktp/'.$perusahaan->id.'/Thumbnail'.$nama_file
        ];

        if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
          //store the fotoktp :
          $perusahaan->dokumen_ktp_penanggung = json_encode($stored);
          $perusahaan->change_by              = Auth::User()->nama;
          $perusahaan->save();

          //Success :
          return response()->json(['Success' => true, 'data' => $stored], 200);
        }
        else {
          $error = ['dokumen_ktp_penanggung' => 'fail because of not an image file!'];
          return response()->json(['Success' => false, 'error' => $error], 401);
        }

      }
      elseif ($request->dokumen_npwp) {
        $file = $request->file('dokumen_npwp');
        $tujuan_upload = public_path().'/dokumen/perusahaan/npwp/'.$perusahaan->id;
        $nama_file     = 'dokumen_npwp'.$perusahaan->id.$random.'.'.$file->getClientOriginalExtension();
        $stored = [
          'original'    => url('/').'/dokumen/perusahaan/npwp/'.$perusahaan->id.'/'.$nama_file,
          'resized'     => url('/').'/dokumen/perusahaan/npwp/'.$perusahaan->id.'/Resized'.$nama_file,
          'thumbnail'   => url('/').'/dokumen/perusahaan/npwp/'.$perusahaan->id.'/Thumbnail'.$nama_file
        ];

        if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
          //store the fotoktp :
          $perusahaan->dokumen_npwp = json_encode($stored);
          $perusahaan->change_by    = Auth::User()->nama;
          $perusahaan->save();

          //Success :
          return response()->json(['Success' => true, 'data' => $stored], 200);
        }
        else {
          $error = ['dokumen_npwp' => 'fail because of not an image file!'];
          return response()->json(['Success' => false, 'error' => $error], 401);
        }
      }
      elseif ($request->dokumen_siup) {
        $file = $request->file('dokumen_siup');
        $tujuan_upload = public_path().'/dokumen/perusahaan/siup/'.$perusahaan->id;
        $nama_file     = 'dokumen_siup'.$perusahaan->id.$random.'.'.$file->getClientOriginalExtension();
        $stored = [
          'original'    => url('/').'/dokumen/perusahaan/siup/'.$perusahaan->id.'/'.$nama_file,
          'resized'     => url('/').'/dokumen/perusahaan/siup/'.$perusahaan->id.'/Resized'.$nama_file,
          'thumbnail'   => url('/').'/dokumen/perusahaan/siup/'.$perusahaan->id.'/Thumbnail'.$nama_file
        ];

        if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
          //store the fotoktp :
          $perusahaan->dokumen_siup = json_encode($stored);
          $perusahaan->change_by    = Auth::User()->nama;
          $perusahaan->save();

          //Success :
          return response()->json(['Success' => true, 'data' => $stored], 200);
        }
        else {
          $error = ['dokumen_siup' => 'fail because of not an image file!'];
          return response()->json(['Success' => false, 'error' => $error], 401);
        }
      }
      else {
        $error = ['fotoktp' => 'upload fail!'];
        return response()->json(['Success' => false, 'error' => $error], 401);
      }

    }

    public function SaveIsianPerusahaan(Request $request) {
      //dd($request->all());
      $user          = User::find(Auth::User()->id);
      $perusahaan    = Perusahaan::find($user->company);
      $perusahaan->nama_perusahaan      = strip_tags($request->nama);
      $perusahaan->alamat_perusahaan    = strip_tags($request->alamat);
      $perusahaan->nomor_telepon        = strip_tags($request->phone);
      $perusahaan->nomor_siup           = strip_tags($request->nomor_siup);
      $perusahaan->nomor_npwp           = strip_tags($request->nomor_npwp);
      $perusahaan->nomor_ktp_penanggung = strip_tags($request->nomor_ktp_penanggung);
      $perusahaan->approved             = 2;
      $perusahaan->save();

      return redirect('dashboard')->with('status', 'Kamu berhasil mendaftarkan identitas perusahaan, Harap menunggu persetujuan admin dkppu!');
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

    protected function generateRandomString($length = 5) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }
}
