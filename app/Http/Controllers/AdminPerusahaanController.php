<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Perusahaan;
use Auth;
use Datatables;
use Intervention\Image\ImageManagerStatic as Image;
use App\HistoryPerusahaan;
use App\drones;

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

    public function getDrones() {
      return view('perusahaan.drones');
    }

    public function addDrones() {
      $user          = new Drones;
      $user->user_id = Auth::User()->id;
      $user->save();
      $id = $user->id;
      return view('perusahaan.add_drones',['id' => $id]);
    }

    public function editDrones($id) {
      $manages = Drones::find($id);
      return view('perusahaan.edit_drones')->with(compact('manages'));
    }

    public function getdronesuser(Request $request,$id){
      $drones = drones::where('id',$id)->where('user_id',Auth::User()->id)->first();
      return view('approval.drones')->with(compact('drones'));
    }

    public function nadronesTB() {
      return Datatables::of(Drones::query()->where('user_id',Auth::User()->id)->where('approved','=','0'))
            ->addColumn('action', function ($datatb) {
              $tambah_button='';
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
                $tambah_button = '<a href="'.$link.'/perusahaan/editDrones/'.$datatb->id.'" class="btn btn-xs btn-warning" type="submit"><i class="fa fa-edit"></i> Edit </a>'
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
              $tambah_button = '<a href="'.$link.'/detail/dronecompuser/'.$datatb->id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> View </a>'
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
      $drones = DB::table('drones')
            ->join('registered_drone', 'drones.id', '=', 'registered_drone.drones_reg')
            ->join('users', function ($join) {
                    $join->on('users.id', '=', 'drones.user_id')
                         ->where('users.company', '=', Auth::User()->company)
                         ->where('users.approved_company','=',1);
            })
            ->select('drones.*', 'registered_drone.nomor_drone as nomor_drone', 'registered_drone.sertifikasi_drone as sertifikasi_drone')
            ->where('registered_drone.company',Auth::User()->company)->where('drones.approved','=','1');

      return Datatables::of($drones)
            ->addColumn('action', function ($datatb) {
              $link = url('/');
              $tambah_button = '<a href="'.$link.'/detail/dronecompuser/'.$datatb->id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> View </a>'
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

    public function getdronesuser2(Request $request,$id){
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

         return redirect('dashboard')->with('status', 'Data telah terupdate!');
    }

    public function getApprovalAnggotaPerusahaan() {
      return view('perusahaan.kelolasendiri');
    }

    public function getAnggotaPerusahaan() {
      return view('perusahaan.anggota');
    }

    public function RemoveUserFromCompany(Request $request) {
      $user = User::find($request->id);
      $user->approved_company = 0;
      $user->save();
      $response = array("success"=>"Berhasil Di Remove");
      return response()->json($response,200);
    }

    public function manageAnggotaJson() {
      $query = DB::table('users')
            ->join('perusahaan', 'users.company', '=', 'perusahaan.id')
            ->select('users.id','users.nama','users.email', 'perusahaan.nama_perusahaan')
            ->where('users.roles_id',3)->where('users.active','1')
            ->where('perusahaan.approved',1)->where('users.approved_company',1)->where('perusahaan.id',Auth::User()->company);
            //dd($query->get());

      return Datatables::of($query)
      // ->addColumn('action', function ($datatb) {
      //     return
      //      '<a href="manage/company/user/approve/'.$datatb->id.'" class="edit-modal btn btn-xs btn-success"><i class="fa fa-edit"></i> Details</a>';
      // })
      ->addColumn('action', function ($datatb) {
        $tambah_button='<a style="margin-left:5px" href="/detail/identitas/adminperu/'.$datatb->id.'" class="edit-modal btn btn-xs btn-info"><i class="fa fa-eye"></i> Details</a> ';
        $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
          return $tambah_button.'<button data-id="'.$datatb->id.'" data-name2="'.$datatb->nama.'" class="delete-modal btn btn-xs btn-danger"><i class="fa fa-trash"></i> Cabut keanggotaan</button>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function manageCompanyJson() {
      $query = DB::table('users')
            ->join('perusahaan', 'users.company', '=', 'perusahaan.id')
            ->select('users.id','users.nama','users.email', 'perusahaan.nama_perusahaan')
            ->where('users.roles_id',3)->where('users.active','1')
            ->where('perusahaan.approved',1)->where('users.approved_company',0)->where('perusahaan.id',Auth::User()->company);
            //dd($query->get());

      return Datatables::of($query)
      // ->addColumn('action', function ($datatb) {
      //     return
      //      '<a href="manage/company/user/approve/'.$datatb->id.'" class="edit-modal btn btn-xs btn-success"><i class="fa fa-edit"></i> Details</a>';
      // })
      ->addColumn('action', function ($datatb) {
        $tambah_button='<a style="margin-left:5px" href="/detail/identitas/adminperu/'.$datatb->id.'" class="edit-modal btn btn-xs btn-info"><i class="fa fa-eye"></i> Details</a> ';
        $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
          return $tambah_button.'<button data-id="'.$datatb->id.'" data-name2="'.$datatb->nama.'" class="delete-modal btn btn-xs btn-success"><i class="fa fa-check"></i> Setujui</button>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function getidentitas(Request $request,$id){
      $user = User::find($id);
      return view('approval.identitas')->with(compact('user'));
    }

    public function ApproveUsertoCompanyByAdmin(Request $request) {
      //dd($request->all());
      $user = User::find($request->id);
      $historyPP = new HistoryPerusahaan;
      $historyPP->id_user = $request->id;
      $historyPP->company = $user->company;
      $historyPP->approved_by = Auth::User()->id;
      $historyPP->save();
      $user->approved_company = 1;
      $response = array("success"=>"Berhasil Di Approve");
      $user->save();
      return response()->json($response,200);
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
