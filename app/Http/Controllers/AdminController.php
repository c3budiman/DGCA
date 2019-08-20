<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Sidebar;
use App\submenu;
use App\frontmenu;
use App\hak_akses_user;
use Excel;
use Datatables;
use App\User;
use App\Soal;
use App\Role;
use App\email;
use App\slider;
use App\drones;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\SettingSitus;
use Storage;
use App\berita;
use Auth;
use App\Events\beritaEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use App\UasRegs;
use App\Ujian;

class AdminController extends Controller
{

  //get role admin : u can change 1 or 2 to id of the admin id that use this controller
  public function getRoleAdmin() {
    $rolesyangberhak = DB::table('roles')->where('id','=','2')->first()->namaRule;
    return $rolesyangberhak;
  }

  public function getRoleSuperAdmin() {
    $rolesyangberhak = DB::table('roles')->where('id','=','1')->first()->namaRule;
    return $rolesyangberhak;
  }

  //batasin role :
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('rule:'.$this->getRoleAdmin().','.$this->getRoleSuperAdmin());
  }

    public function getFront() {
      return view('front.index');
    }

    public function editFront($id) {
      $front = frontmenu::find($id);
      //dd($id);
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=',$front->method)->where('id_akses','=','1')->count() > 0) {
        if ($front->method == 'home') {
          return view('front.edithome', ['front'=>$front]);
        } elseif ($front->method == 'news_digest') {
          return view('front.editnews', ['front'=>$front]);
        } else {
          return view('front.edit', ['front'=>$front]);
        }
      } else {
        return redirect('/dashboard')->withErrors(['You dont have access to do that!']);
      }

    }

    public function postEditFront(Request $request) {
      $data = frontmenu::find($request->id);
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=',$data->method)->where('id_akses','=','3')->count() > 0) {
        $data->nama = $request->nama;
        $data->content = $request->content;
        $data->save();

        return redirect('front')->with('status', 'Frontmenu '.$request->nama.' has been updated!');
      } else {
        return redirect('/dashboard')->withErrors(['You dont have access to do that!']);
      }
    }

    public function postEditFront2(Request $request) {
      $data = frontmenu::find($request->id);
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=',$data->method)->where('id_akses','=','3')->count() > 0) {
        $data->nama = $request->nama;
        $data->content = $request->content;
        $data->save();

        $response = array("success"=>"Frontmenu Altered");
        return response()->json($response,200);
      } else {
        $response = array("eror"=>"You dont have access to do that!");
        return response()->json($response,200);
      }
    }

    public function frontDataTB() {
      return Datatables::of(frontmenu::query())
      ->addColumn('action', function ($datatb) {
          $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
          return
           '<a target="_blank" href="'.$link.'/'.$datatb->method.'" class="edit-modal btn btn-xs btn-success" ><i class="fa fa-eye"></i> View</a>'
           .'<div style="padding-top:10px"></div>'
           .'<a href="'.$link.'/front/edit/'.$datatb->id.'" class="edit-modal btn btn-xs btn-info" ><i class="fa fa-edit"></i> Edit</a>'
           .'<a style="margin-left:5px" target="_blank" href="/front/'.$datatb->id.'/editadvance" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Code Editor</a>'
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function getEditFrontAdvance($id) {
      $front = frontmenu::find($id);
      return view('front.editadvance',['front'=>$front]);
    }


    public function postFront(Request $request) {
        try {
          //insert new front menu to database :
          $tabel = new frontmenu;
          $tabel->nama = $request->menu;
          $tabel->method = strtolower($request->method);
          //create new tabel for submenu :
          Schema::create(strtolower($request->method), function($table)
          {
              $table->increments('id');
              $table->unsignedInteger('parent')->nullable();
              $table->string('nama');
              $table->string('method');
              $table->text('content');
              $table->timestamps();
          });


          //generate code for crud backend, view for frontend
          //yang ini masih on progress...
          $exitCode = Artisan::call('crud:generator', ['name' => strtolower($request->method)]);

          $tabel->save();
          $response = array("success"=>"Sukses");
          return response()->json($response,200);
        } catch (\Exception $e) {
          $response = array("error"=>"$e");
          return response()->json($response,200);
        }
    }

    public function deleteFront(Request $request) {
      $front = frontmenu::find($request->id);
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=',$front->method)->where('id_akses','=','4')->count() > 0) {
        File::delete(app_path("/{$front->method}.php"));
        File::delete(app_path("/Http/Controllers/{$front->method}Controller.php"));
        File::delete(app_path("/Http/Requests/{$front->method}Request.php"));
        File::delete(base_path("/resources/views/auto/{$front->method}.blade.php"));
        $view = DB::table($front->method)->get();
        if (DB::table($front->method)->count() > 0) {
          foreach ($view as $v) {
            File::delete(base_path("/resources/views/subauto/".$v->method.".blade.php"));
          }
        }
        DB::table('hak_akses_user')->where('menu', '=', $front->method)->delete();

        Schema::dropIfExists($front->method);
        $front->delete();

        $response = array("success"=>"Successfully added");
        return response()->json($response,200);
      } else {
        $response = array("error"=>"Anda tak punya akses untuk melakukan hal itu!");
        return response()->json($response,501);
      }
    }

    public function EditSubmenuFront($method, $id) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=',$method)->where('id_akses','=','3')->count() > 0) {
        $front = DB::table($method)->where('id','=',$id)->first();
        return view('front.submenu_edit',['front'=>$front]);
      } else {
        return redirect('/dashboard')->withErrors(['You dont have access to do that!']);
      }
    }

    public function deleteSubmenuFront(Request $request) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=',$request->method)->where('id_akses','=','4')->count() > 0) {
        $sub = DB::table($request->method)->where('id','=',$request->id);
        if ($sub->count() > 0) {
          $method = $sub->first()->method;
          File::delete(base_path("/resources/views/subauto/".$method.".blade.php"));
          $sub->delete();
          $response = array("success"=>"Test Gan");
          return response()->json($response,200);
        }
      } else {
        $response = array("error"=>"You dont have access to do that!");
        return response()->json($response,501);
      }
    }

    public function EditSubmenuFrontPost(Request $request) {
      $method = frontmenu::find($request->parent)->method;
      $sub = DB::table($method)->where('id','=',$request->id)
            ->update([
                      'nama' => $request->nama,
                      'content'=> $request->content
                    ]);

      return redirect($method.'/editsub/'.$request->id)->with('status', 'Submenu '.$request->nama.' has been updated!');
    }

    public function getAddSlidebar() {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','home')->where('id_akses','=','1')->count() > 0) {
        return view('front.slidebaradd');
      }
      else {
        $response = array("error"=>"You dont have access to do that!");
        return response()->json($response,501);
      }

    }

    public function postAddSlidebar(Request $request){
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','home')->where('id_akses','=','2')->count() > 0) {
        //dd($request->hasFile('tes'));
        if ($request->hasFile('tes')) {
          $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
          $namafile = $request->file('tes')->getClientOriginalName();
          $ext = $request->file('tes')->getClientOriginalExtension();
          $newNamaFile = md5($namafile.date("Y/m/d")) .'.' .$ext;
          // yg paling penting cek extension, no php allowed
          if ($ext == "png" || $ext == "jpg" || $ext == "jpeg" || $ext == "PNG" || $ext == "JPG" || $ext == "JPEG") {
            //store
            $destinasi = public_path('storage/slider/');
            //dd($destinasi);
            $proses = $request->file('tes')->move($destinasi,$newNamaFile);
            $lokasifileskr = $link.'/storage/slider/'.$newNamaFile;
          } else {
            return Redirect::back()->withErrors(['file format error']);
          }
          $data = new slider;
          $data->title = $request->title;
          $data->description = $request->description;
          $data->image = $lokasifileskr;
          $data->save();
          return redirect('front/edit/1')->with('status', 'Slider added!');
        }
        else {
          $data = new slider;
          $data->title = $request->title;
          $data->description = $request->description;
          $data->image = "https://static1.squarespace.com/static/59562732f7e0ab94574ba86a/595cec37b8a79b20409a1118/5b8d3cc11ae6cf1d7df86281/1535982812270/sudarshan-bhat-102013-unsplash.jpg?format=1500w";
          $data->save();
          return redirect('front/edit/1')->with('status', 'Slider added!');
        }
      }
      else {
        $response = array("error"=>"You dont have access to do that!");
        return response()->json($response,501);
      }
    }

    public function getEditSlider($id) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','home')->where('id_akses','=','3')->count() > 0) {
        $slide = slider::find($id);
        return view('front.editslide', ['slide'=>$slide]);
      }
      else {
        $response = array("error"=>"You dont have access to do that!");
        return response()->json($response,501);
      }
    }

    public function putEditSlider(Request $request) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','home')->where('id_akses','=','3')->count() > 0) {

        $slide = slider::find($request->id);

        if ($request->hasFile('tes')) {
          $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
          $namafile = $request->file('tes')->getClientOriginalName();
          $ext = $request->file('tes')->getClientOriginalExtension();
          $newNamaFile = md5($namafile.date("Y/m/d")) .'.' .$ext;
          // yg paling penting cek extension, no php allowed
          if ($ext == "png" || $ext == "jpg" || $ext == "jpeg" || $ext == "PNG" || $ext == "JPG" || $ext == "JPEG") {
            //store
            $destinasi = public_path('../../storage/slider/');
            //dd($destinasi);
            $proses = $request->file('tes')->move($destinasi,$newNamaFile);
            $lokasifileskr = $link.'/storage/slider/'.$newNamaFile;
          } else {
            return Redirect::back()->withErrors(['file format error']);
          }
          $slide->title = $request->title;
          $slide->description = $request->description;
          $slide->image = $lokasifileskr;
          $slide->save();
          return redirect('front/edit/1')->with('status', 'Slider Altered!');
        }
        else {
          $slide->title = $request->title;
          $slide->description = $request->description;
          $slide->save();
          return redirect('front/edit/1')->with('status', 'Slider added!');
        }
      }
      else {
        $response = array("error"=>"You dont have access to do that!");
        return response()->json($response,501);
      }
    }

    public function slideDataTB() {
      return Datatables::of(slider::query())
      ->addColumn('action', function ($datatb) {
        $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
          return
           '<a href="'.$link.'/edit/slide/'.$datatb->id.'" class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Edit</a>'
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->title.'" class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addIndexColumn()
      ->addColumn('imagesnya', function($datatb) {
        return '<img src="'.$datatb->image.'" alt="" height="50px">';
      })
      ->make(true);
    }

    public function deleteSlider(Request $request) {
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=','home')->where('id_akses','=','4')->count() > 0) {
        $slide = slider::find($request->id);
        $slide->delete();

        $response = array("success"=>"Deleted Successfully");
        return response()->json($response,200);
      }
      else {
        $response = array("error"=>"You dont have access to do that!");
        return response()->json($response,501);
      }
    }

    public function approveidentitasTB(){
      $user = User::whereIn('id', function($query)
      {
          $query->select('user_id')
                ->from('uas_regs')
                ->whereRaw('uas_regs.user_id = users.id')
                ->where('status',3)->where('softdelete',0);
      })
      ->where('roles_id','3')->where('approved','=','')->orWhere('approved', 0)
      ->get();

      return Datatables::of($user)
      ->addColumn('action', function ($datatb) {
          return
           '<a href="detail/identitas/'.$datatb->id.'" class="edit-modal btn btn-xs btn-success" type="submit"><i class="fa fa-edit"></i> Details</a>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function approveidentitasTB2(){
      return Datatables::of(User::query()->where('roles_id','3')->where('approved','=','1')->get())
      ->addColumn('action', function ($datatb) {
          return
           '<a href="detail/identitas/'.$datatb->id.'" class="edit-modal btn btn-xs btn-success" type="submit"><i class="fa fa-edit"></i> Details</a>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function approveidentitas(){
      return view('approval.index');
    }

    public function getidentitas(Request $request,$id){
      $user = User::find($id);
      return view('approval.identitas')->with(compact('user'));
    }

    public function approvedidentitas(Request $request,$id) {
      $user = User::find($id);
      $user->approved = 1;
      $user->save();
      return redirect('approveidentitas')->with('succes', 'User successfuly approved!');
    }

    public function approvedronesTB(){
      return Datatables::of(drones::query()->where('approved','0')->orderBy('id','desc')->get())
      ->addColumn('action', function ($datatb) {
          return
           '<a href="detail/drones/'.$datatb->id.'" class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Details</a>';
      })
      ->addColumn('nama', function($datatb) {
        return '<a href="detail/identitas/'.$datatb->user_id.'"> '.DB::table('users')->where('id','=',$datatb->user_id)->first()->nama.' </a>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function approvedronesTB2(){
      return Datatables::of(drones::query()->where('approved','1')->orderBy('id','desc')->get())
      ->addColumn('action', function ($datatb) {
          return
           '<a href="detail/drones/'.$datatb->id.'" class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Details</a>';
      })
      ->addColumn('nama', function($datatb) {
        return '<a href="detail/identitas/'.$datatb->user_id.'"> '.DB::table('users')->where('id','=',$datatb->user_id)->first()->nama.' </a>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function approvedrones(){
      return view('approval.index2');
    }

    public function getdrones(Request $request,$id){
      $drones = drones::find($id);
      return view('approval.drones')->with(compact('drones'));
    }

    public function approveddrones(Request $request,$id){
      $drones = drones::find($id);
      $drones->approved = 1;
      $drones->save();
      return redirect('approvedrones')->with('succes', 'User successfuly approved!');
    }

    public function getApprovalUAS() {
      return view('approval.index_uas');
    }

    public function approveUasDataTB()
    {
      return Datatables::of(UasRegs::query()->where('status','2')->where('softdelete',0)->orderBy('id','desc')->get())
      ->addColumn('action', function ($datatb) {
          return
           '<a href="detail/uas/'.$datatb->id.'/1" class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Details</a>';
      })
      ->addColumn('nama', function($datatb) {
        return '<a href="'.url('/').'/detail/identitas/'.$datatb->user_id.'"> '.DB::table('users')->where('id','=',$datatb->user_id)->first()->nama.' </a>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function approvedUasDataTB()
    {
      return Datatables::of(UasRegs::query()->where('status','3')->where('softdelete',0)->orderBy('id','desc')->get())
      ->addColumn('action', function ($datatb) {
          return
           '<a href="detail/uas/'.$datatb->id.'" class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Details</a>';
      })
      ->addColumn('nama', function($datatb) {
        return '<a href="'.url('/').'/detail/identitas/'.$datatb->user_id.'"> '.DB::table('users')->where('id','=',$datatb->user_id)->first()->nama.' </a>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function getUasApproval($uas_regs)
    {
      if (DB::table('ujian')
                  ->where('ujian_regs', $uas_regs)->count() > 1)
      {
        $jml_soal_per = 10;
        $jumlah_soal  = DB::table('ujian')
                        ->where('ujian_regs', $uas_regs)->count();
        $jumlah_page  = ceil($jumlah_soal / $jml_soal_per);
        $soal         = DB::table('ujian')
                        ->where('ujian_regs', $uas_regs)->take($jml_soal_per)->get();
        $uas_reg      = UasRegs::find($uas_regs);
        $nama_orang   = User::find($uas_reg->user_id);

        return view('approval.uas_detail',['uas_reg'=>$uas_reg,'nama_orang'=>$nama_orang,'uas_regs'=>$uas_regs,'soal'=>$soal,'jumlah_page'=>$jumlah_page]);
      }
      else {
        return Redirect::back()->withErrors(['Not Found!']);
      }

    }

    public function getUasApprovalWithPage($uas_regs,$page) {
      if (DB::table('ujian')
                  ->where('ujian_regs', $uas_regs)->count() > 0)
      {
        $jumlah_soal  = DB::table('ujian')
                        ->where('ujian_regs', $uas_regs)->count();
        $jml_soal_per = 10;
        $jumlah_page  = ceil($jumlah_soal / $jml_soal_per);
        $skip         = 0;
        $start_at     = ($page * $jml_soal_per) - ($jml_soal_per - 1);
        if ($page != 1) {
          $skip = $jml_soal_per*($page-1);
        }

        $soal         = DB::table('ujian')
                        ->where('ujian_regs', $uas_regs)->skip($skip)->take($jml_soal_per)->get();

        return view('approval.uas_detail_withpage',['uas_regs'=>$uas_regs,'soal'=>$soal,'jumlah_page'=>$jumlah_page,'page'=>$page,'start_at'=>$start_at]);
      }
      else {
        return Redirect::back()->withErrors(['Not Found!']);
      }
    }

    public function UasApprovalFinished($uas_regs){
      if (DB::table('ujian')
                  ->where('ujian_regs', $uas_regs)->count() > 0)
      {
        $soal         = DB::table('ujian')
                        ->where('ujian_regs', $uas_regs)->get();
        $jumlah_soal = count($soal);
        $nama_orang     = User::find($uas_reg->user_id);

        return view('approval.uas_detail',['nama_orang'=>$nama_orang,'uas_regs'=>$uas_regs,'soal'=>$soal,'jumlah_soal'=>$jumlah_soal]);
      }
      else {
        return Redirect::back()->withErrors(['Not Found!']);
      }
    }

    public function saveKepuasan(Request $request){
      if (DB::table('ujian')
                  ->where('ujian_regs', $request->uas_regs)->where('id',$request->id)->count() > 0)
      {
        $data = Ujian::where('ujian_regs', $request->uas_regs)->where('id',$request->id)->first();
        $data->satisfy = $request->satisfy;
        $data->save();
        $response = array("success"=>"Sukses terupdate");
        return response()->json($response,200);
      }
      else {
        $response = array("error"=>"Not Found!");
        return response()->json($response,404);
      }
    }

    public function saveketerangan(Request $request) {
      if (DB::table('ujian')
                  ->where('ujian_regs', $request->uas_regs)->where('id',$request->id)->count() > 0)
      {
        $data = Ujian::where('ujian_regs', $request->uas_regs)->where('id',$request->id)->first();
        $data->remarks = $request->keterangan;
        $data->save();
        $response = array("success"=>"Sukses terupdate");
        return response()->json($response,200);
      }
      else {
        $response = array("error"=>"Not Found!");
        return response()->json($response,404);
      }
    }

    public function getFinishAssesment($uas_regs) {
      if (DB::table('ujian')
                  ->where('ujian_regs', $uas_regs)->count() > 0)
      {
        $data           = Ujian::where('ujian_regs', $uas_regs);
        $ujian_ternilai = $data->whereNotNull('satisfy')->count();
        $ujian_total    = $data->count();
        $ujian_puas     = Ujian::where('ujian_regs', $uas_regs)->where('satisfy',1)->count();
        $ujian_tpuas    = Ujian::where('ujian_regs', $uas_regs)->where('satisfy',2)->count();
        $ujian_netral   = Ujian::where('ujian_regs', $uas_regs)->where('satisfy',99)->count();
        $uas_reg        = UasRegs::find($uas_regs);
        $nama_orang     = User::find($uas_reg->user_id);

        $nilai          = 0;
        $data_ujian     = Ujian::where('ujian_regs', $uas_regs)->get();
        foreach ($data_ujian as $ujian) {
          if ($ujian->satisfy == 1) {
            $nilai+=1;
          }
        }
        $ujian_total    = count($data_ujian);
        $skor_pass      = round($ujian_total/2);
        $nilai_fix      = $nilai/$ujian_total * 100;

        if ($nilai_fix > $skor_pass) {
          $status = 'Lulus';
        }
        else {
          $status = 'Tidak Lulus';
        }

        return view('approval.finish_assesment',['status'=>$status,'nilai_fix'=>$nilai_fix,'nama_orang'=>$nama_orang,'uas_regs'=>$uas_regs,'ujian_total'=>$ujian_total,'ujian_ternilai'=>$ujian_ternilai,'ujian_puas'=>$ujian_puas,'ujian_tpuas'=>$ujian_tpuas,'ujian_netral'=>$ujian_netral]);
      }
      else {
        return Redirect::back()->withErrors(['Not Found!']);
      }
    }

    public function FinishUasAssesmentFix(Request $request) {
      if (DB::table('ujian')
                  ->where('ujian_regs', $request->uas_regs)->count() > 0)
      {
        $nilai      = 0;
        $data_ujian = Ujian::where('ujian_regs', $request->uas_regs)->get();
        $uas_regs   = UasRegs::find($request->uas_regs);
        foreach ($data_ujian as $ujian) {
          if ($ujian->satisfy == 1) {
            $nilai+=1;
          }
        }
        //nilai harus di atas 50% klo mau approve :
        $ujian_total = count($data_ujian);
        $skor_pass   = round($ujian_total/2);
        $nilai_fix            = $nilai/$ujian_total * 100;
        $uas_regs->nilai      = $nilai_fix;
        $uas_regs->change_by  = Auth::User()->nama;

        if ($nilai >= $skor_pass) {
          $uas_regs->status = 3;
        }
        else {
          $uas_regs->status = 4;
        }
        $uas_regs->save();
        return redirect('approval/uas')->with('succes', 'Assesment Saved!');;
      }
      else {
        return Redirect::back()->withErrors(['Not Found!']);
      }
    }




}
