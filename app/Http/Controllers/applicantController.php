<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Drones;
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

    public function uploadIdentitas2(Request $request) {
      $file = $request->file('upload_doc2');
      $user = User::find(Auth::User()->id);

      if ($file) {
          $tujuan_upload = public_path().'/dokumen/sertifikasi/'.Auth::User()->id;
          $nama_file = 'FotoSertifikasi_'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
          //upload :
          if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
            //store the fotoktp :
            $stored = [
              'original'    => url('/').'/dokumen/sertifikasi/'.Auth::User()->id.'/'.$nama_file,
              'resized'     => url('/').'/dokumen/sertifikasi/'.Auth::User()->id.'/Resized'.$nama_file,
              'thumbnail'   => url('/').'/dokumen/sertifikasi/'.Auth::User()->id.'/Thumbnail'.$nama_file
            ];
            $user->dokumen_sertifikasi = json_encode($stored);
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

    public function addDrones() {
      return view('applicant.add_drones');
    }

    public function editDrones($id) {
      $manages = Drones::find($id);
      return view('applicant.edit_drones')->with(compact('manages'));
    }

    public function nadronesTB() {
      return Datatables::of(Drones::query()->where('approved','=','0'))
            ->addColumn('action', function ($datatb) {
              $tambah_button='';
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
                $tambah_button = '<a href="'.$link.'/editDrones/'.$datatb->id.'" class="btn btn-xs btn-warning" type="submit"><i class="fa fa-edit"></i> Edit </a>'
                .'<div style="padding-top:10px"></div>';
                return
                 $tambah_button
                .'<button data-id="'.$datatb->id.'" class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function appdronesTB() {
      return Datatables::of(Drones::query()->where('approved','=','1'))
            ->addColumn('action', function ($datatb) {
              $tambah_button='';
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
                return
                 $tambah_button
                .'<button data-id="'.$datatb->id.'" class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function deleteDrones(Request $request, Drones $drones){
      $drones = Drones::find($request->id);
      $drones->softdelete = 1;
      $drones->save();
      $drones->delete();
      //membuat response array, untuk di tampilkan menjadi json nantinya
      $response = array("success"=>"Drone Deleted");

      return response()->json($response,200);
    }

    public function uploadDokumenUAS(Request $request) {
      $file = $request->file('bukti_kepemilikan');
      // $namaoriginal = $request->file('bukti_kepemilikan')->getClientOriginalName();
      // dd($namaoriginal);
      $user = DB::table('drones')->where('user_id','=',Auth::User()->id)->first();
      // dd($user);
      if($user == null){
          $user = new Drones;
          if ($file) {
              $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
              // $nama_file = $namaoriginal.'_'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
              $nama_file = 'FotoKepemilikan_'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
              // dd($nama_file);

              //upload :
              if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
                //store the fotoktp :
                $stored = [
                  'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
                  'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
                  'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
                ];
                $user->proof_of_ownership = json_encode($stored);
                $user->user_id = Auth::User()->id;
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
      }else{
        $user = DB::table('drones')->where('user_id','=',Auth::User()->id)->first();
      if ($file) {
          $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
          $nama_file = $request->proof_of_ownership.'_'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
          //upload :
          if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
            //store the fotoktp :
            $stored = [
              'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
              'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
              'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
            ];
            DB::table('drones')->where('user_id', Auth::User()->id)->update(
              ['proof_of_ownership' => json_encode($stored),
             ]);


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
    }

    public function uploadPenguasaan(Request $request) {
      $file = $request->file('buktipenguasaan');
      $user = DB::table('drones')->where('user_id','=',Auth::User()->id)->first();
      if($user == null){
          $user = new Drones;
          if ($file) {
              $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
              $nama_file = 'FotoBuktiPenguasaan'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
              // dd($nama_file);

              //upload :
              if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
                //store the fotoktp :
                $stored = [
                  'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
                  'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
                  'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
                ];
                $user->scan_proof_of_ownership = json_encode($stored);
                $user->user_id = Auth::User()->id;
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
      }else{
      if ($file) {
          $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
          $nama_file = 'FotoBuktiPenguasaan'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
          // dd($nama_file);

          //upload :
          if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
            //store the fotoktp :
            $stored = [
              'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
              'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
              'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
            ];
            DB::table('drones')->where('user_id', Auth::User()->id)->update(
              ['scan_proof_of_ownership' => json_encode($stored),
             ]);
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
      }

    public function uploadPesawat(Request $request) {
      $file = $request->file('fotopesawat');
      $user = DB::table('drones')->where('user_id','=',Auth::User()->id)->first();
      if($user == null){
          $user = new Drones;
          if ($file) {
              $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
              $nama_file = 'FotoPesawat'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
              // dd($nama_file);

              //upload :
              if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
                //store the fotoktp :
                $stored = [
                  'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
                  'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
                  'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
                ];
                $user->pic_of_drones = json_encode($stored);
                $user->user_id = Auth::User()->id;
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
      }else{
      if ($file) {
          $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
          $nama_file = 'FotoNoSeriPesawat'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
          // dd($nama_file);

          //upload :
          if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
            //store the fotoktp :
            $stored = [
              'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
              'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
              'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
            ];
            DB::table('drones')->where('user_id', Auth::User()->id)->update(
              ['pic_of_drones' => json_encode($stored),
             ]);
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
      }

    public function uploadPesawatSn(Request $request) {
      $file = $request->file('nomorseripesawat');
      $user = DB::table('drones')->where('user_id','=',Auth::User()->id)->first();
      if($user == null){
          $user = new Drones;
          if ($file) {
              $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
              $nama_file = 'FotoPesawatSn'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
              // dd($nama_file);

              //upload :
              if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
                //store the fotoktp :
                $stored = [
                  'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
                  'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
                  'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
                ];
                $user->pic_of_drones_with_sn = json_encode($stored);
                $user->user_id = Auth::User()->id;
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
      }else{
      if ($file) {
          $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
          $nama_file = 'FotoPesawatSn'.Auth::User()->id.'.'.$file->getClientOriginalExtension();
          // dd($nama_file);

          //upload :
          if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
            //store the fotoktp :
            $stored = [
              'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
              'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
              'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
            ];
            DB::table('drones')->where('user_id', Auth::User()->id)->update(
              ['pic_of_drones_with_sn' => json_encode($stored),
             ]);
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
      }

    public function postDrones(Request $request) {
      DB::table('drones')->where('user_id', Auth::User()->id)->insert(
        [//drone bio
         'manufacturer' => $request->manufacturer,
         'model' => $request->model,
         'specific_model' => $request->modelspesific,
         'model_year' => $request->yearmake,
         'serial_number' => $request->nomorseri,
         'condition' => $request->condition,
         'max_weight_take_off' => $request->weighttakeoff,

         //kepemilikan UAS
         'termofowenership' => $request->termofowenership,
         'owner' => $request->owner,
         'address' => $request->address,
         'evidenceofowenership' => $request->evidenceofowenership,
         'dateownership' => $request->dateownership,

         //penguasaan UAS
         'termofposession' => $request->termofposession,
         'reference' => $request->reference,
         'namapemberisewa' => $request->namapemberisewa,
         'alamatpemberisewa' => $request->alamatpemberisewa,
         'emailpemberisewa' => $request->emailpemberisewa,
         'nomorteleponpemberisewa' => $request->nomorteleponpemberisewa
       ]);

       // $status = DB::table('user_step')->where('user_id',Auth::User()->id)->update(
       //   ['kode_status' => '4','status' => DB::table('status_list')->where('kode_status','4')->first()->keterangan]
       // );

       return redirect('dashboard')->with('status', 'Kamu berhasil menambahkan drone!');
      // dd($request->all());
    }

    public function updateDrones(Request $request,$id) {
        $drones=Drones::find($id);
        //drone bio
         $drones->manufacturer = $request->manufacturer;
         $drones->model = $request->model;
         $drones->specific_model = $request->modelspesific;
         $drones->model_year = $request->yearmake;
         $drones->serial_number = $request->nomorseri;
         $drones->condition = $request->condition;
         $drones->max_weight_take_off = $request->weighttakeoff;

         //kepemilikan UAS
         $drones->termofowenership = $request->termofowenership;
         $drones->owner = $request->owner;
         $drones->address = $request->address;
         $drones->evidenceofowenership = $request->evidenceofowenership;
         $drones->dateownership = $request->dateownership;

         //penguasaan UAS
         $drones->termofposession = $request->termofposession;
         $drones->reference = $request->reference;
         $drones->namapemberisewa = $request->namapemberisewa;
         $drones->alamatpemberisewa = $request->alamatpemberisewa;
         $drones->emailpemberisewa = $request->emailpemberisewa;
         $drones->nomorteleponpemberisewa = $request->nomorteleponpemberisewa;


       // $status = DB::table('user_step')->where('user_id',Auth::User()->id)->update(
       //   ['kode_status' => '4','status' => DB::table('status_list')->where('kode_status','4')->first()->keterangan]
       // );
       // dd($drones);
       $drones->save();
       return redirect('dashboard')->with('status', 'Data telah terupdate!');
      // dd($request->all());
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
