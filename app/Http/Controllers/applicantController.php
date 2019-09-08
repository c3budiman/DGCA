<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\drones;
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
use App\UasRegs;
use App\Ujian;
use App\RegisteredDrone;


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

    public function getUasAssesment() {
      //generate soal, klo dia belum pernah ada uas_regs sebelumnya yang aktif.
      if (DB::table('uas_regs')->where('user_id',Auth::User()->id)->where('softdelete',0)->count() < 1 ) {
        //insert ke table uas_regs :
        $data = new UasRegs;
        $data->user_id = Auth::User()->id;
        $data->status = 1;
        $data->change_by = Auth::User()->nama;

        $soalnya = DB::table('soal')->where('aktif','1')->get();

        if ($data->save()) {
          foreach ($soalnya as $soal) {
            $ujian = new Ujian;
            $ujian->ujian_regs = $data->id;
            $ujian->user_id = Auth::User()->id;
            $ujian->id_soal = $soal->id;
            $ujian->save();
          }
          return view('applicant.uasAsessment',['uas_regs'=>$data, 'soal'=>$soal]);
        }
        else {
          return Redirect::back()->withErrors(['Error while saving, please try again later!']);
        }
      }
      else {
        $uas_regs = DB::table('uas_regs')
                    ->where('user_id', Auth::User()->id)
                    ->where('softdelete',0)->first();

        $soal     = DB::table('ujian')
                    ->where('user_id', Auth::User()->id)
                    ->where('ujian_regs', $uas_regs->id)->get();
        //cek apa dia udah kelar, udah di approve, apa belom ujian nya :
        if ($uas_regs->status == 2) {
          return view('applicant.uasAsessmentFinished', ['approved'=>false] );
        }
        elseif ($uas_regs->status == 3) {
          return view('applicant.uasAsessmentFinished', ['approved'=>true] );
        }
        else {
          $last_soalnya=1;
          if (DB::table('ujian')
                      ->where('user_id', Auth::User()->id)
                      ->where('ujian_regs', $uas_regs->id)
                      ->where('jawaban', NULL)->count() > 0) {
            $last_soal = DB::table('ujian')
                        ->where('user_id', Auth::User()->id)
                        ->where('ujian_regs', $uas_regs->id)
                        ->where('jawaban', NULL)
                        ->orderBy('id_soal','asc')->first();
            $last_soalnya = $last_soal->id;
          }
          // dd('uas_assesment_now/'.$last_soalnya.'/'.$uas_regs->id);
          return redirect('uas_assesment_now/'.$last_soalnya.'/'.$uas_regs->id);

        }
      }

    }

    public function getSoalUjian($id, $id_regs, Request $request) {
      if (UasRegs::where('user_id',Auth::User()->id)
                  ->where('id',$id_regs)
                  ->where('softdelete',0)
                  ->where('status',1)
                  ->count() > 0)
      {
          //dd(DB::table('ujian')->where('user_id', Auth::User()->id)->where('ujian_regs', $id_regs)->where('id', $id)->count());
          if (DB::table('ujian')->where('user_id', Auth::User()->id)->where('ujian_regs', $id_regs)->count() > 0) {
              $id_soal = Ujian::find($id)->id_soal;

              $current_soal = DB::table('soal')
                                ->where('id', $id_soal)
                                ->first();

              $all_soal = DB::table('ujian')
                                ->where('user_id', Auth::User()->id)
                                ->where('ujian_regs', $id_regs)
                                ->get();

              return view('applicant.ujian',['current_soal'=>$current_soal, 'all_soal'=>$all_soal,'id_regs'=>$id_regs]);
          }
          else {
              return redirect('dashboard')->withErrors(['Error Anda Telah Mensubmit UAS Assesment!']);
          }
      }
      else {
          return Redirect::back()->withErrors(['Error UAS Assesment tidak ditemukan!']);
      }

    }

    public function FinishUASA($uas_regs) {
      $soal_terjawab        = DB::table('ujian')
                            ->where('user_id', Auth::User()->id)
                            ->where('ujian_regs', $uas_regs)
                            ->whereNotNull('jawaban')
                            ->count();

      $semua_soal           = DB::table('ujian')
                            ->where('user_id', Auth::User()->id)
                            ->where('ujian_regs', $uas_regs)
                            ->count();

      return view( 'applicant.finish_ujian', ['soal_terjawab'=>$soal_terjawab, 'semua_soal'=>$semua_soal, 'uas_regs'=>$uas_regs] );
    }

    public function FinishFix($uas_regs) {
      if (DB::table('uas_regs')
                  ->where('user_id',Auth::User()->id)
                  ->where('id',$uas_regs)
                  ->where('softdelete',0)->count())
      {
          $uas_reg = UasRegs::where('user_id',Auth::User()->id)
                      ->where('id',$uas_regs)
                      ->where('softdelete',0)->first();
          //set it to already ujian :
          $uas_reg->status = 2;
          if ($uas_reg->save()) {
            return redirect('dashboard')->with('succes', 'Berhasil Mensubmit Uas Assesment!');
          }
          else {
            return Redirect::back()->withErrors(['Silahkan coba kembali!']);
          }

      }
      else {
        return Redirect::back()->withErrors(['Not Found!']);
      }

    }

    public function saveJawabanAssesment($id, $id_regs, Request $request) {
      $last_soalnya = 1;

      if (DB::table('ujian')
                  ->where('user_id', Auth::User()->id)
                  ->where('ujian_regs', $id_regs)
                  ->where('jawaban', NULL)->count() > 0) {
        $ujian = Ujian::where('id_soal',$id)->where('user_id', Auth::User()->id)->where('ujian_regs', $id_regs)->first();
        $ujian->jawaban = $request->jawaban;
        $ujian->save();
        $last_soal = DB::table('ujian')
                    ->where('user_id', Auth::User()->id)
                    ->where('ujian_regs', $id_regs)
                    ->where('jawaban', NULL)
                    ->orderBy('id_soal','asc')->first();
        if ( $last_soal ) {
          $last_soalnya = $last_soal->id_soal;
        } else {
          return redirect('finish_ujian/'.$id_regs);
        }

      }

      return redirect('uas_assesment_now/'.$last_soalnya.'/'.$id_regs);
    }

    public function UpdateRPIdentitas(Request $request) {
      $user               = User::find(Auth::User()->id);
      $user->nama         = $request->nama;
      $user->phone        = $request->phone;
      $user->ktp          = $request->ktp;
      $user->save();

      return response()->json(['Success' => true], 200);
    }

    public function UpdateRPAlamatIdentitas(Request $request) {
      if ($request->village && $request->regency && $request->district && $request->provinsi) {
        $user            = User::find(Auth::User()->id);
        $address         = '';
        $address        .= DB::table('villages')->where('id',$request->village)->first()->name;
        $address        .= '\, '.DB::table('regencies')->where('id',$request->regency)->first()->name;
        $address        .= '\, '.DB::table('districts')->where('id',$request->district)->first()->name;
        $address        .= '\, '.DB::table('provinces')->where('id',$request->provinsi)->first()->name;
        $user->address   = $address;
        $user->save();

        return response()->json(['Success' => true], 200);
      } else {
        return response()->json(['Success' => false], 200);
      }

    }

    public function FinalisasiRemotePilot(Request $request) {
      $user          = User::find(Auth::User()->id);
      if ($user->dokumen_identitas && $user->dokumen_sertifikasi) {
        return response()->json(['Success' => true], 200);
      } else {
        return response()->json(['Success' => false], 200);
      }
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
          $random        = $this->generateRandomString();
          $nama_file = 'FotoIdentitas_'.Auth::User()->id.$random.'.'.$file->getClientOriginalExtension();
          //upload :
          if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
            //store the fotoktp :
            $stored = [
              'original'    => url('/').'/dokumen/ktp/'.Auth::User()->id.'/'.$nama_file,
              'resized'     => url('/').'/dokumen/ktp/'.Auth::User()->id.'/Resized'.$nama_file,
              'thumbnail'   => url('/').'/dokumen/ktp/'.Auth::User()->id.'/Thumbnail'.$nama_file
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
          $random        = $this->generateRandomString();
          $nama_file = 'FotoSertifikasi_'.Auth::User()->id.$random.'.'.$file->getClientOriginalExtension();
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
      $address .= '\, '.DB::table('regencies')->where('id',$request->regency)->first()->name;
      $address .= '\, '.DB::table('districts')->where('id',$request->district)->first()->name;
      $address .= '\, '.DB::table('provinces')->where('id',$request->provinsi)->first()->name;

      if ($user->dokumen_identitas) {
        $user->nama         = $request->nama;
        $user->phone        = $request->phone;
        $user->address      = $address;
        $user->address_code = $request->regency;
        //todo : upload foto dokumen dan save.
        $user->save();

        $status = DB::table('user_step')->where('user_id',$user->id)->update(
          ['kode_status' => '3','status' => DB::table('status_list')->where('kode_status','3')->first()->keterangan]
        );

        return redirect('dashboard')->with('status', 'Kamu berhasil mendaftarkan identitas, Silahkan tambahkan drone yang akan di terbangkan di menu Drone!');
      }
      else {
        return Redirect::back()->withErrors(['Silahkan Upload Foto Identitas!']);
      }

    }

    //get isi identitas :
    public function getDrones() {
      return view('applicant.drones');
    }

    public function addDrones() {
      $user          = new Drones;
      $status        = DB::table('user_step')->where('user_id', Auth::User()->id)->first()->kode_status;
      $array_status  = [1,2];
      if (!in_array($status, $array_status)) {
        $user->user_id = Auth::User()->id;
        $user->save();
        $id = $user->id;
      } else {
        $id = 0;
      }
      return view('applicant.add_drones',['id' => $id]);
    }

    public function editDrones($id) {
      $manages = Drones::find($id);
      return view('applicant.edit_drones')->with(compact('manages'));
    }

    public function getdronesuser(Request $request,$id){
      if (drones::where('id',$id)->count() > 0) {
        $drones = drones::where('id',$id)->first();
        $user_company = User::where('id',$drones->user_id)->first()->company;
        if (Auth::User()->company == $user_company) {
          return view('approval.drones')->with(compact('drones'));
        } else {
          $drones = drones::where('id',$id)->where('user_id',Auth::User()->id)->first();
          return view('approval.drones')->with(compact('drones'));
        }
      } else {
        return Redirect::back()->withErrors(['Not Found!']);
      }

    }

    public function nadronesTB() {
      return Datatables::of(Drones::query()->where('user_id',Auth::User()->id)->where('approved','=','0'))
            ->addColumn('action', function ($datatb) {
              $tambah_button='';
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
                $tambah_button = '<a href="'.$link.'/editDrones/'.$datatb->id.'" class="btn btn-xs btn-warning" type="submit"><i class="fa fa-edit"></i> Edit </a>'
                .'<div style="padding-top:10px"></div>';
                return
                 $tambah_button
                .'<button data-id="'.$datatb->id.'" class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
            })
            ->addColumn('drones_image', function($datatb) {
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
              if ($datatb->pic_of_drones) {
                return '<a href="'.json_decode($datatb->pic_of_drones)->original.'"><img src="'.json_decode($datatb->pic_of_drones)->resized.'" alt="" height="100px"></a>';
              } else {
                return '';
              }
            })
            ->addIndexColumn()
            ->addColumn('drones_image', function($datatb) {
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
              if ($datatb->pic_of_drones) {
                return '<a href="'.json_decode($datatb->pic_of_drones)->original.'"><img src="'.json_decode($datatb->pic_of_drones)->resized.'" alt="" height="100px"></a>';
              } else {
                return '';
              }
            })
            ->make(true);
    }

    public function appdronesTB() {
      $drones = DB::table('drones')
            ->join('registered_drone', 'drones.id', '=', 'registered_drone.drones_reg')
            ->select('drones.*', 'registered_drone.nomor_drone as nomor_drone', 'registered_drone.sertifikasi_drone as sertifikasi_drone')
            ->where('drones.user_id',Auth::User()->id)->where('drones.approved','=','1');
     //dd($drones);

      return Datatables::of($drones)
            ->addColumn('action', function ($datatb) {
              $link = url('/');
              $tambah_button = '<a href="'.$link.'/detail/dronesuser/'.$datatb->id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> View </a>'
              .'<div style="padding-top:10px"></div>';
              $tambah_button .= '<a href="'.$datatb->sertifikasi_drone.'" class="btn btn-xs btn-success"><i class="fa fa-download"></i> Download Sertifikat </a>'
              .'<div style="padding-top:10px"></div>';
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
                return
                 $tambah_button;
            })
            ->addColumn('pic_of_drones', function($datatb) {
              $link = url('/').'/';
              if ($datatb->pic_of_drones) {
                return '<a href="'.json_decode($datatb->pic_of_drones)->original.'"><img src="'.json_decode($datatb->pic_of_drones)->resized.'" alt="" height="100px"></a>';
              } else {
                return '';
              }
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function companyDronesDataTB() {
      $drones= null;
      if (Auth::User()->approved_company == 1) {
        $drones = DB::table('drones')
              ->join('registered_drone', 'drones.id', '=', 'registered_drone.drones_reg')
              ->join('users', function ($join) {
                      $join->on('users.id', '=', 'drones.user_id')
                           ->where('users.company', '=', Auth::User()->company)
                           ->where('users.approved_company','=',1);
              })
              ->select('drones.*', 'registered_drone.nomor_drone as nomor_drone', 'registered_drone.sertifikasi_drone as sertifikasi_drone')
              ->where('registered_drone.company',Auth::User()->company)->where('drones.approved','=','1');
      } else {
        $drones = DB::table('drones')
              ->join('registered_drone', 'drones.id', '=', 'registered_drone.drones_reg')
              ->join('users', function ($join) {
                      $join->on('users.id', '=', 'drones.user_id')
                           ->where('users.company', '=', Auth::User()->company)
                           ->where('users.approved_company','=',1);
              })
              ->select('drones.*', 'registered_drone.nomor_drone as nomor_drone', 'registered_drone.sertifikasi_drone as sertifikasi_drone')
              ->where('drones.approved','=','99');
      }

      return Datatables::of($drones)
            ->addColumn('action', function ($datatb) {
              $link = url('/');
              $tambah_button = '<a href="'.$link.'/detail/dronesuser/'.$datatb->id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> View </a>'
              .'<div style="padding-top:10px"></div>';
              $tambah_button .= '<a href="'.$datatb->sertifikasi_drone.'" class="btn btn-xs btn-success"><i class="fa fa-download"></i> Download Sertifikat </a>'
              .'<div style="padding-top:10px"></div>';
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
                return
                 $tambah_button;
            })
            ->addColumn('pic_of_drones', function($datatb) {
              $link = url('/').'/';
              if ($datatb->pic_of_drones) {
                return '<a href="'.json_decode($datatb->pic_of_drones)->original.'"><img src="'.json_decode($datatb->pic_of_drones)->resized.'" alt="" height="100px"></a>';
              } else {
                return '';
              }
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function deleteDrones(Request $request, Drones $drones){
      //dd($request->all());
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

      if( $request->id ) {
          //$exist_drone = Drones::where('id',$request->id);
          if ($file) {
              $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
              $random        = $this->generateRandomString();

              $nama_file = $request->proof_of_ownership.'_'.$random.Auth::User()->id.'.'.$file->getClientOriginalExtension();
              //upload :
              if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
                //store the fotoktp :
                $stored = [
                  'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
                  'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
                  'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
                ];
                DB::table('drones')->where('id', $request->id)->update(
                  ['proof_of_ownership' => json_encode($stored),
                 ]);

                //Success :
                return response()->json(['Success' => true, 'data' => $stored], 200);
              }
              else {
                $error = ['bukti_kepemilikan' => 'fail because of not an image file!'];
                return response()->json(['Success' => false, 'error' => $error], 401);
              }
          }
          else {
            // upload fail because the file is not exist / request is half way through
            $error = ['fotoktp' => 'upload fail!'];
            return response()->json(['Success' => false, 'error' => $error], 401);
          }
      }
    }

    public function uploadPenguasaan(Request $request) {
      $file = $request->file('buktipenguasaan');
      if( $request->id ) {
          //$exist_drone = Drones::where('id',$request->id);
          if ($file) {
              $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
              $random        = $this->generateRandomString();
              $nama_file     = 'FotoBuktiPenguasaan'.Auth::User()->id.$random.'.'.$file->getClientOriginalExtension();

              //upload :
              if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
                //store the fotoktp :
                $stored = [
                  'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
                  'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
                  'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
                ];
                DB::table('drones')->where('id', $request->id)->update(
                  ['scan_proof_of_ownership' => json_encode($stored)]
                );
                //Success :
                return response()->json(['Success' => true, 'data' => $stored], 200);
              }
              else {
                $error = ['fotoktp' => 'fail because of not an image file!'];
                return response()->json(['Success' => false, 'error' => $error], 401);
              }
          }
          else {
            // upload fail because the file is not exist / request is half way through
            $error = ['fotoktp' => 'upload fail!'];
            return response()->json(['Success' => false, 'error' => $error], 401);
          }
      }
    }

    public function uploadPesawat(Request $request) {
      $file = $request->file('fotopesawat');
      if( $request->id ) {
          //$exist_drone = Drones::where('id',$request->id);
          //dd($exist_drone->get());
          if ($file) {
              $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
              $random        = $this->generateRandomString();
              $nama_file     = 'FotoPesawat'.Auth::User()->id.$random.'.'.$file->getClientOriginalExtension();

              //upload :
              if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
                //store the fotoktp :
                $stored = [
                  'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
                  'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
                  'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
                ];
                DB::table('drones')->where('id', $request->id)->update(
                  ['pic_of_drones' => json_encode($stored) ]
                );
                //Success :
                return response()->json(['Success' => true, 'data' => $stored], 200);
              }
              else {
                $error = ['fotoktp' => 'fail because of not an image file!'];
                return response()->json(['Success' => false, 'error' => $error], 401);
              }
          }
          else {
            // upload fail because the file is not exist / request is half way through
            $error = ['fotoktp' => 'upload fail!'];
            return response()->json(['Success' => false, 'error' => $error], 401);
          }
      }
    }

    public function uploadPesawatSn(Request $request) {
      $file = $request->file('nomorseripesawat');

      if( $request->id ) {
          $exist_drone = Drones::where('id',$request->id);
          if ($file) {
              $tujuan_upload = public_path().'/dokumen/uas/'.Auth::User()->id;
              $random        = $this->generateRandomString();
              $nama_file     = 'FotoPesawatSn'.Auth::User()->id.$random.'.'.$file->getClientOriginalExtension();

              //upload :
              if ($this->uploadImage($file, $tujuan_upload, $nama_file)) {
                //store the fotoktp :
                $stored = [
                  'original'    => url('/').'/dokumen/uas/'.Auth::User()->id.'/'.$nama_file,
                  'resized'     => url('/').'/dokumen/uas/'.Auth::User()->id.'/Resized'.$nama_file,
                  'thumbnail'   => url('/').'/dokumen/uas/'.Auth::User()->id.'/Thumbnail'.$nama_file
                ];
                DB::table('drones')->where('id', $request->id)->update(
                  ['pic_of_drones_with_sn' => json_encode($stored)]
                );
                //Success :
                return response()->json(['Success' => true, 'data' => $stored], 200);
              }
              else {
                $error = ['fotoktp' => 'fail because of not an image file!'];
                return response()->json(['Success' => false, 'error' => $error], 401);
              }
          }
          else {
            // upload fail because the file is not exist / request is half way through
            $error = ['fotoktp' => 'upload fail!'];
            return response()->json(['Success' => false, 'error' => $error], 401);
          }
      }
    }

    public function postDrones(Request $request) {
       //status drone :
       //1 created.
       //null belom lengkap
       //2 approved.
       //3 tolak/tunda.
       $exist_drone = Drones::where('user_id', Auth::User()->id)->where('status',NULL)->where('uas_id',NULL);
       if ($exist_drone->count() > 0) {
          //update drone yang last edit aja :
          $drones=Drones::find($exist_drone->first()->id);

          //drone bio
          $drones->manufacturer        = $request->manufacturer;
          $drones->model               = $request->model;
          $drones->specific_model      = $request->modelspesific;
          $drones->model_year          = $request->yearmake;
          $drones->serial_number       = $request->nomorseri;
          $drones->condition           = $request->condition;
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
          $drones->status = 1;
          $drones->save();
          $id_drone = $drones->id;
       }
       else {
         $id_drone = DB::table('drones')->where('user_id', Auth::User()->id)->insert(
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
          $id_drone = $id_drone->id;
       }

       $status = DB::table('user_step')->where('user_id',Auth::User()->id)->update(
         ['kode_status' => '4','status' => 'Berhasil Mendaftarkan Drone Dengan Id : '.$id_drone]
       );

       return redirect('dashboard')->with('status', 'Kamu berhasil menambahkan drone!');
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

         $drones->save();

         $status = DB::table('user_step')->where('user_id',Auth::User()->id)->update(
           ['kode_status' => '4','status' => 'Berhasil Mengupdate Drone Dengan Id : '.$drones->id]
         );

         return redirect('dashboard')->with('status', 'Data telah terupdate!');
    }

    public function getPindahPerusahaan() {
      return view('applicant.pindahCompany');
    }

    public function doPindahPerusahaan(Request $request) {
      //dd($request->all());
      $user = User::find(Auth::User()->id);
      $user->approved_company = 0;
      $user->company = $request->perusahaan;
      $user->save();
      if (RegisteredDrone::where('user_id',Auth::User()->id)->count() > 0) {
        $drone_user = RegisteredDrone::where('user_id',Auth::User()->id)->get();
        foreach ($drone_user as $reg_drone) {
          $registered_drone = RegisteredDrone::find($reg_drone->id);
          $registered_drone->company = $request->perusahaan;
          $registered_drone->save();
        }
      }
      return redirect('dashboard')->with('status', 'Data telah terupdate!');
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
