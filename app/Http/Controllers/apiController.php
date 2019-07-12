<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class apiController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getProvinsi($nama) {
    $prov = DB::table('provinces')->where('name','like','%'.$nama.'%');
    if ($prov->count() > 0) {
      $response = array(
        [
          'status'  => 200,
          'message' => "Found",
          'province'=> $prov->take(5)->get()
        ]
      );
    } else {
      $response = array(
        [
          'status' => 404,
          'message'=> "Not Found"
        ]
      );
    }
    return response()->json($response,200);
  }

  public function getRegency($id) {
    $nama = isset($_GET['search']) ? $_GET['search'] : '';
    $regs = DB::table('regencies')->where('province_id','=',$id);
    if (isset($_GET['search'])) {
      $regs->where('name','like','%'.$nama.'%');
    }
    return response()->json($regs->get(),200);
  }

  public function getDistrict($id) {
    $nama = isset($_GET['search']) ? $_GET['search'] : '';
    $district = DB::table('districts')->where('regency_id','=',$id);
    if (isset($_GET['search'])) {
      $district->where('name','like','%'.$nama.'%');
    }
    return response()->json($district->get(),200);
  }

  public function getVillage($id) {
    $nama = isset($_GET['search']) ? $_GET['search'] : '';
    $villages = DB::table('villages')->where('district_id','=',$id);
    if (isset($_GET['search'])) {
      $villages->where('name','like','%'.$nama.'%');
    }
    return response()->json($villages->get(),200);
  }

}
