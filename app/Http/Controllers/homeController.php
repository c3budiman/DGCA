<?php

namespace App\Http\Controllers;

use App\Http\Requests\homeRequest;
use App\home;
use Auth;
use Datatables;
use DB;
use Illuminate\Support\Facades\File;

class homeController extends Controller
{

    public function index()
    {
        $homes = home::latest()->get();

        return response()->json($homes);
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

    public function store(homeRequest $request)
    {
        if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','home')->where('id_akses','=','2')->count() > 0) {
          $this->middleware('auth');
          $home = home::create($request->all());
          $this->view('home',$request->method);

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
        $home = home::findOrFail($id);

        return response()->json($home);
    }

    public function update(homeRequest $request, $id)
    {
        $home = home::findOrFail($id);
        $home->update($request->all());

        return response()->json($home, 200);
    }

    public function destroy($id)
    {
        if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','home')->where('id_akses','=','4')->count() > 0) {
          home::destroy($id);
          return response()->json(null, 204);
        } else {
          $response = array("error"=>"You dont have access to do that!!");
          return response()->json($response,501);
        }
    }

    public function editsub($id) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','home')->where('id_akses','=','3')->count() > 0) {
        $data = home::find($id);
        return view('auto.home_edit', ['data'=>$data]);
      } else {
        $response = array("error"=>"You dont have access to do that!!");
        return response()->json($response,501);
      }
    }

    public function getFront() {
      return view('index');
    }

    public function dataTB() {
      return Datatables::of(home::query())
      ->addColumn('action', function ($datatb) {
          $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
          return
           '<a target="_blank" href="'.$link.'/home/'.$datatb->method.'" class="show-modal btn btn-xs btn-success" ><i class="fa fa-eye"></i> View</a>'
           .'<div style="padding-top:10px"></div>'
           .'<a href="'.$link.'/home/editsub/'.$datatb->id.'" class="edit2-modal btn btn-xs btn-info" ><i class="fa fa-edit"></i> Edit</a>'
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addIndexColumn()
      ->make(true);
    }
}
