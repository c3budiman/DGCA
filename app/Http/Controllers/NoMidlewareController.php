<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RegisteredDrone;
use App\RemotePilot;
use DB;

class NoMidlewareController extends Controller
{
  public function GetVerifDrone($nomor_drone) {
    $drones = DB::table('drones')
          ->join('registered_drone', 'drones.id', '=', 'registered_drone.drones_reg')
          ->leftJoin('users', 'users.id', '=', 'drones.user_id')
          ->select('drones.*', 'users.nama', 'users.email', 'registered_drone.nomor_drone as nomor_drone', 'registered_drone.created_at as csr', 'registered_drone.status', 'registered_drone.sertifikasi_drone as sertifikasi_drone')
          ->where('registered_drone.nomor_drone',$nomor_drone)->first();
    return view('confirm.drone',['drones' => $drones]);
  }

  public function GetVerifRemotePilot($nomor_pilot) {
    $remote_pilot = DB::table('remote_pilot')
          ->join('users', 'users.id', '=', 'remote_pilot.user_id')
          ->select('users.*', 'remote_pilot.nomor_pilot','remote_pilot.status', 'remote_pilot.sertifikasi_pilot','remote_pilot.created_at as csr')
          ->where('remote_pilot.nomor_pilot',$nomor_pilot)->first();
    return view('confirm.remote_pilot',['remote_pilot' => $remote_pilot]);
  }
}
