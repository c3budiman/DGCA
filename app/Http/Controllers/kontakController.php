<?php

namespace App\Http\Controllers;

use App\Http\Requests\kontakRequest;
use App\kontak;
use Auth;
use Datatables;
use DB;
use Illuminate\Support\Facades\File;

class kontakController extends Controller
{

    public function index()
    {
        $kontaks = kontak::latest()->get();

        return response()->json($kontaks);
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

    public function store(kontakRequest $request)
    {
        if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','kontak')->where('id_akses','=','2')->count() > 0) {
          $this->middleware('auth');
          $kontak = kontak::create($request->all());
          $this->view('kontak',$request->method);

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
        $kontak = kontak::findOrFail($id);

        return response()->json($kontak);
    }

    public function update(kontakRequest $request, $id)
    {
        $kontak = kontak::findOrFail($id);
        $kontak->update($request->all());

        return response()->json($kontak, 200);
    }

    public function destroy($id)
    {
        if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','kontak')->where('id_akses','=','4')->count() > 0) {
          kontak::destroy($id);
          return response()->json(null, 204);
        } else {
          $response = array("error"=>"You dont have access to do that!!");
          return response()->json($response,501);
        }
    }

    public function editsub($id) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','kontak')->where('id_akses','=','3')->count() > 0) {
        $data = kontak::find($id);
        return view('auto.kontak_edit', ['data'=>$data]);
      } else {
        $response = array("error"=>"You dont have access to do that!!");
        return response()->json($response,501);
      }
    }

    public function getFront() {
      return view('auto.kontak');
    }

    public function dataTB() {
      return Datatables::of(kontak::query())
      ->addColumn('action', function ($datatb) {
          $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
          return
           '<a target="_blank" href="'.$link.'/kontak/'.$datatb->method.'" class="show-modal btn btn-xs btn-success" ><i class="fa fa-eye"></i> View</a>'
           .'<div style="padding-top:10px"></div>'
           .'<a href="'.$link.'/kontak/editsub/'.$datatb->id.'" class="edit2-modal btn btn-xs btn-info" ><i class="fa fa-edit"></i> Edit</a>'
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addIndexColumn()
      ->make(true);
    }
}
