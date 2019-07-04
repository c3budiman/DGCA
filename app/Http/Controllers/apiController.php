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

  public function getRegency($id,$nama) {
    $regs = DB::table('regencies')->where('province_id','=',$id)->where('name','like','%'.$nama.'%');
    if ($regs->count() > 0) {
      $response = array(
        [
          'status'  => 200,
          'message' => "Found",
          'province'=> $regs->take(5)->get()
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

  public function getDistrict($id,$nama) {
    $district = DB::table('districts')->where('regency_id','=',$id)->where('name','like','%'.$nama.'%');
    if ($district->count() > 0) {
      $response = array(
        [
          'status'  => 200,
          'message' => "Found",
          'province'=> $district->take(5)->get()
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

  public function getVillage($id,$nama) {
    $villages = DB::table('villages')->where('district_id','=',$id)->where('name','like','%'.$nama.'%');
    if ($villages->count() > 0) {
      $response = array(
        [
          'status'  => 200,
          'message' => "Found",
          'province'=> $villages->take(5)->get()
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

}
