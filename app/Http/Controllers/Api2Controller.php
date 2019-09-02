<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;

class Api2Controller extends Controller
{
  public function getRolePengguna() {
    $rolesyangberhak = DB::table('roles')->where('id','=','5')->first()->namaRule;
    return $rolesyangberhak;
  }

  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('rule:'.$this->getRolePengguna().','.'nothingelse');
  }

  public function tesadmin(User $user, Request $request) {
    //$user = User::where('api_token', $request->api_token)->first();
    $user2 = Auth::User();
    return response()->json(['user' => $user2], 200);
  }

  public function tesadmin2(User $user, Request $request) {
    $user = User::where('api_token', $request->api_token)->first();
    return response()->json(['user' => $user], 200);
  }

  public function getRemotePilot(Request $request) {
    $now  = date('Y-m-d');
    $from = $now;
    $to   = $now;
    $email  = '';
    $nama   = '';
    if ($request->from && $request->to) {
      $from = date($request->from);
      $to   = date($request->to);
    }
    if ($request->email) {
      $email=$request->email;
    }
    if ($request->nama) {
      $nama=$request->nama;
    }

    $data = DB::table('remote_pilot')
          ->join('users', 'users.id', '=', 'remote_pilot.user_id')
          ->leftJoin('perusahaan', 'perusahaan.id', '=', 'users.company')
          ->select('users.nama', 'users.email', 'users.address','users.company as id_company', 'users.phone', 'users.ktp as national_id', 'perusahaan.nama_perusahaan',
          'remote_pilot.nomor_pilot as license_number','remote_pilot.status', 'remote_pilot.sertifikasi_pilot','remote_pilot.created_at as created_times')
          ->whereBetween('remote_pilot.created_at', [$from, $to])
          ->where('email','like','%'.$email.'%')
          ->where('nama','like','%'.$nama.'%');

    if ($request->company_id) {
      $data->where('users.company','=',$request->company_id);
    }

    $count = $data->count();
    $data_fix = NULL;
    $data->orderBy('remote_pilot.created_at', 'desc');
    if ($count > 0) {
      $data_fix = $data->get();
    }
    return response()->json(['count' => $count,'data' => $data_fix], 200);
  }

  public function getDrone(Request $request) {
    $now  = date('Y-m-d');
    $from = $now;
    $to   = $now;
    $email = null;
    $nomor_drone = null;
    if ($request->from && $request->to) {
      $from = date($request->from);
      $to   = date($request->to);
    }
    if ($request->nomor_drone) {
      $nomor_drone = $request->nomor_drone;
    }
    if ($request->email) {
      $email = $request->email;
    }

    $drones = DB::table('drones')
          ->join('registered_drone', 'drones.id', '=', 'registered_drone.drones_reg')
          ->leftJoin('users', 'users.id', '=', 'drones.user_id')
          ->leftJoin('perusahaan', 'perusahaan.id', '=', 'users.company')
          ->select(
            'users.nama', 'users.email',
            'perusahaan.nama_perusahaan',
            'registered_drone.company as company_id_drone',
            'registered_drone.nomor_drone as nomor_drone',
            'registered_drone.created_at as updated_at',
            'registered_drone.status',
            'registered_drone.sertifikasi_drone as sertifikasi_drone',
            'drones.manufacturer',
            'drones.model',
            'drones.specific_model',
            'drones.model_year',
            'drones.serial_number',
            'drones.condition',
            'drones.max_weight_take_off',
            'drones.termofowenership',
            'drones.owner', 'drones.address',
            'drones.evidenceofowenership', 'drones.dateownership',
            'drones.termofposession', 'drones.pic_of_drones',
            'drones.pic_of_drones_with_sn', 'drones.scan_proof_of_ownership',
            'drones.proof_of_ownership'
          )
          ->where('registered_drone.nomor_drone','like', '%'.$nomor_drone.'%')
          ->where('users.email','like','%'.$email.'%')
          ->whereBetween('registered_drone.created_at', [$from, $to]);
    //dd($drones->get());
    if ($request->company_id) {
      $drones->where('registered_drone.company','=',$request->company_id);
    }

    $count = $drones->count();
    $data_fix = NULL;
    $drones->orderBy('registered_drone.created_at', 'desc');
    if ($count > 0) {
      $data_fix = $drones->get();
    }
    return response()->json(['count' => $count,'data' => $data_fix], 200);
  }

  public function getCompany() {
    $perusahaan = DB::table('perusahaan')
                  ->select('id','nama_perusahaan as name','nomor_telepon as phone','alamat_perusahaan as address')
                  ->where('approved',1);
    $count = $perusahaan->count();
    $data_fix = NULL;
    $perusahaan->orderBy('perusahaan.created_at', 'desc');
    if ($count > 0) {
      $data_fix = $perusahaan->get();
    }
    return response()->json(['count' => $count,'data' => $data_fix], 200);
  }


}
