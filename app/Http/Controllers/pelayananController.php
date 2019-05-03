<?php

namespace App\Http\Controllers;

use App\Http\Requests\pelayananRequest;
use App\pelayanan;
use Auth;
use Datatables;
use DB;
use Illuminate\Support\Facades\File;

class pelayananController extends Controller
{

    public function index()
    {
        $pelayanans = pelayanan::latest()->get();

        return response()->json($pelayanans);
    }

    protected function getStub($type)
    {
        return file_get_contents(base_path("resources/stubs/$type.stub"));
    }

    protected function view($name,$method)
    {
        $viewTemplate = str_replace(
            [
              '{{ModelMenu}}',
              '{{methodSubMenuName}}'
            ],
            [
              strtolower($name),
              strtolower($method)
            ],
            $this->getStub('View3')
        );

        file_put_contents(base_path("/resources/views/subauto/".$method.".blade.php"), $viewTemplate);
    }

    public function store(pelayananRequest $request)
    {
        if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','pelayanan')->where('id_akses','=','2')->count() > 0) {
          $this->middleware('auth');
          $pelayanan = pelayanan::create($request->all());
          $this->view('pelayanan',$request->method);

          $response = array("success"=>"Submenu Inserted");
          return response()->json($response,200);
        } else {
          $response = array("error"=>"You dont have access to do that!!");
          return response()->json($response,501);
        }
    }

    public function viewSubmenu($method){
      return view('subauto.'.$method);
    }

    public function show($id)
    {
        $pelayanan = pelayanan::findOrFail($id);

        return response()->json($pelayanan);
    }

    public function update(pelayananRequest $request, $id)
    {
        $pelayanan = pelayanan::findOrFail($id);
        $pelayanan->update($request->all());

        return response()->json($pelayanan, 200);
    }

    public function destroy($id)
    {
        if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','pelayanan')->where('id_akses','=','4')->count() > 0) {
          pelayanan::destroy($id);
          return response()->json(null, 204);
        } else {
          $response = array("error"=>"You dont have access to do that!!");
          return response()->json($response,501);
        }
    }

    public function editsub($id) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','pelayanan')->where('id_akses','=','3')->count() > 0) {
        $data = pelayanan::find($id);
        return view('auto.pelayanan_edit', ['data'=>$data]);
      } else {
        $response = array("error"=>"You dont have access to do that!!");
        return response()->json($response,501);
      }
    }

    public function getFront() {
      return view('auto.pelayanan');
    }

    public function dataTB() {
      return Datatables::of(pelayanan::query())
      ->addColumn('action', function ($datatb) {
          $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
          return
           '<a target="_blank" href="'.$link.'/pelayanan/'.$datatb->method.'" class="show-modal btn btn-xs btn-success" ><i class="fa fa-eye"></i> View</a>'
           .'<div style="padding-top:10px"></div>'
           .'<a href="'.$link.'/pelayanan/editsub/'.$datatb->id.'" class="edit2-modal btn btn-xs btn-info" ><i class="fa fa-edit"></i> Edit</a>'
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addIndexColumn()
      ->make(true);
    }
}
