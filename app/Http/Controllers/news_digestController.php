<?php

namespace App\Http\Controllers;

use App\Http\Requests\news_digestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\news_digest;
use Auth;
use Datatables;
use DB;
use App\news;
use Illuminate\Support\Facades\File;


class news_digestController extends Controller
{

    public function index()
    {
        $news_digests = news_digest::latest()->get();

        return response()->json($news_digests);
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

    public function store(news_digestRequest $request)
    {
        if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','news_digest')->where('id_akses','=','2')->count() > 0) {
          $this->middleware('auth');
          $news_digest = news_digest::create($request->all());
          $this->view('news_digest',$request->method);

          $response = array("success"=>"Submenu Inserted");
          return response()->json($response,200);
        } else {
          return redirect('/dashboard')->withErrors(['Anda tak punya akses untuk mengakses halaman!']);
        }
    }

    public function viewSubmenu($method){
      return view('subauto.'.$method);
    }

    public function show($id)
    {
        $news_digest = news_digest::findOrFail($id);

        return response()->json($news_digest);
    }

    public function update(news_digestRequest $request, $id)
    {
        $news_digest = news_digest::findOrFail($id);
        $news_digest->update($request->all());

        return response()->json($news_digest, 200);
    }

    public function destroy($id)
    {
        if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','news_digest')->where('id_akses','=','4')->count() > 0) {
          news_digest::destroy($id);
          return response()->json(null, 204);
        } else {
          return redirect('/dashboard')->withErrors(['Anda tak punya akses untuk mengakses halaman!']);
        }
    }

    public function editsub($id) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','news_digest')->where('id_akses','=','3')->count() > 0) {
        $data = news_digest::find($id);
        return view('auto.news_digest_edit', ['data'=>$data]);
      } else {
        return redirect('/dashboard')->withErrors(['Anda tak punya akses untuk mengakses halaman!']);
      }
    }

    public function getFront() {
      $data = DB::table('news_text')->orderBy('updated_at', 'desc')->paginate(6);
      return view('auto.news_digest', ['data'=>$data]);
    }

    public function dataTB() {
      return Datatables::of(news_digest::query())
      ->addColumn('action', function ($datatb) {
          $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
          return
           '<a target="_blank" href="'.$link.'/news_digest/'.$datatb->method.'" class="show-modal btn btn-xs btn-success" ><i class="fa fa-eye"></i> View</a>'
           .'<div style="padding-top:10px"></div>'
           .'<a href="'.$link.'/news_digest/editsub/'.$datatb->id.'" class="edit2-modal btn btn-xs btn-info" ><i class="fa fa-edit"></i> Edit</a>'
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function dataTB2() {
      return Datatables::of(news::query())
      ->addColumn('action', function ($datatb) {
          $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
          return
          '<a target="_blank" href="'.$link.'/news_digests/id/'.$datatb->id.'" class="show-modal btn btn-xs btn-success" ><i class="fa fa-eye"></i> View</a>'
           .'<div style="padding-top:10px"></div>'
           .'<a href="'.$link.'/news_digest/edit/'.$datatb->id.'" class="edit2-modal btn btn-xs btn-info" ><i class="fa fa-edit"></i> Edit</a>'
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->title.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addColumn('authornya', function($datatb) {
        return DB::table('users')->where('id','=',$datatb->author)->first()->nama;
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function getFrontNews($id) {
      $data = news::find($id);
      return view('front.news.view', ['data'=>$data]);
    }

    public function getAddNews() {
      return view('front.news.add');
    }

    public function postNews(Request $request) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','news_digest')->where('id_akses','=','2')->count() > 0) {
        $data = new news;
        $data->title = strip_tags($request->title);
        $data->src = strip_tags($request->src);
        $data->content = $request->content;
        $data->excerpt = substr(strip_tags($request->content), 0, 300);
        $data->created_at = $request->date;
        $data->author = Auth::User()->id;

        $data->save();
        return Redirect::back()->with('status', 'News Created!');
      } else {
        return redirect('/dashboard')->withErrors(['You dont have access to do that!']);
      }
    }

    public function getEditNews($id) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','news_digest')->where('id_akses','=','3')->count() > 0) {
        $data = news::find($id);
        return view('front.news.edit', ['data'=>$data]);
      } else {
        return redirect('/dashboard')->withErrors(['You dont have access to do that!']);
      }
    }

    public function putNews(Request $request) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','news_digest')->where('id_akses','=','3')->count() > 0) {
        $data = news::find($request->id);
        $data->title = strip_tags($request->title);
        $data->created_at = $request->date;
        $data->content = $request->content;
        $data->excerpt = substr(strip_tags($request->content), 0, 300);
        $data->save();

        return Redirect::back()->with('status', 'News has been updated successfully!');
      } else {
        return redirect('/dashboard')->withErrors(['Anda tak punya akses untuk mengakses halaman!']);
      }
    }

    public function deleteNews(Request $request) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','news_digest')->where('id_akses','=','4')->count() > 0) {
        $data = news::find($request->id);
        $data->delete();

        $response = array("success"=>"successfully deleted");
        return response()->json($response,200);

      } else {
        $response = array("error"=>"You dont have access to do that!");
        return response()->json($response,501);
      }
    }
}
