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
use App\slide;
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

class WebAdminController extends Controller
{
    public function getRoleAdmin() {
      $rolesyangberhak = DB::table('roles')->where('id','=','1')->first()->namaRule;
      return $rolesyangberhak;
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('rule:'.$this->getRoleAdmin().',nothingelse');
    }


    // Memulai Seksi Sidebar
    // .
    // .
    public function getSidebarSetting() {
      return view('sidebar.index');
    }

    public function sidebarDataTB() {
      return Datatables::of(Sidebar::query())
            ->addColumn('Owner', function($datatb) {
              return DB::table('roles')->where('id','=',$datatb->kepunyaan)->first()->namaRule;
            })
            ->addColumn('realicon', function($datatb) {
              return '<i class="'.$datatb->class_css.'"></i>';
            })
            ->addColumn('action', function ($datatb) {
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
                return
                 '<a style="margin-left:5px" href="'.$link.'/sidebar/'.$datatb->id.'/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>'
                 .'<div style="padding-top:10px"></div>'
                .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function addsidebar() {
      return view('sidebar.tambahsidebar');
    }

    public function editSidebar($id) {
      $sidebar = Sidebar::find($id);
      if (!$sidebar) {
        abort(404);
      }
      return view('sidebar.editsidebar', ['sidebar'=>$sidebar, 'id'=>$id]);
    }

    public function tambahSidebarAjax(Request $request, Sidebar $sidebar) {
        $this->validate($request, [
          'nama'      => 'required',
          'class_css' => 'required',
          'link'      => 'required',
        ]);
        $sidebar = new Sidebar();
        $sidebar->nama = strip_tags($request->nama);
        $sidebar->kepunyaan = strip_tags($request->roles_id);
        $sidebar->class_css = strip_tags($request->class_css);
        $sidebar->link = strip_tags($request->link);
        $sidebar->save();

        $response = array("success"=>"Sidebar Added");
        return response()->json($response,201);
    }

    public function deleteSidebar(Request $request) {
      $this->validate($request, [
        'id'      => 'required',
      ]);
      $sidebar = Sidebar::find($request->id);
      $sidebar->delete();

      $response = array("success"=>"Sidebar Deleted");
      return response()->json($response,200);
    }

    public function postDataSidebar($sidebar) {
      $sidebar->nama = strip_tags(Input::get('nama'));
      $sidebar->kepunyaan = strip_tags(Input::get('roles_id'));
      $sidebar->class_css = strip_tags(Input::get('class_css'));
      $sidebar->link = strip_tags(Input::get('link'));
      $sidebar->save();
    }

    public function updateSidebar($id) {
      $sidebar = Sidebar::find($id);
      $this->postDataSidebar($sidebar);
      return redirect('/sidebarsettings')->with('status', 'Sidebar successfuly updated!');
    }

    public function getAddSubMenu($id) {
      $sidebar = Sidebar::find($id);
      return view('sidebar.submenuadd', ['sidebar'=>$sidebar, 'id'=>$id]);
    }

    public function PostAddSubmenu(Request $request) {
      $this->validate($request, [
        'nama'      => 'required',
        'link'      => 'required',
      ]);
      $submenu = new submenu();
      $submenu->kepunyaan = $request->id;
      $submenu->nama = strip_tags($request->nama);
      $submenu->link = strip_tags($request->link);
      $submenu->save();
      $response = array("success"=>"Submenu Added");
      return response()->json($response,201);
    }

    public function editsubmenu(Request $request) {
      $this->validate($request, [
        'id'      => 'required',
        'nama'      => 'required',
        'link'      => 'required',
      ]);
      $submenu = submenu::find($request->id);
      $submenu->nama = strip_tags($request->nama);
      $submenu->link = strip_tags($request->link);
      $submenu->save();
      $response = array("success"=>"Submenu Edited");
      return response()->json($response,200);
    }

    public function deleteSubmenu(Request $request) {
      $this->validate($request, [
        'id'      => 'required',
      ]);

      $submenu = submenu::find($request->id);
      $submenu->delete();

      $response = array("success"=>"Submenu Deleted");
      return response()->json($response,200);
    }

    public function submenuDataTB($id) {
      $submenu = DB::table('submenu')->where('kepunyaan', $id);
        return Datatables::of($submenu)
            ->addColumn('action', function ($datatb) {
                return
                '<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-kepunyaan="'.$datatb->kepunyaan.'" data-link="'.$datatb->link.'"  class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Edit</button>'
                .'<div style="margin-top:10px"></div>'
                .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
            })
            ->addIndexColumn()
            ->make(true);
    }
    // Akhir Seksi Sidebar


    //Memulai Seksi pengguna
    // .
    // .
    public function userDataTB() {

      return Datatables::of(User::query())
            ->addColumn('action', function ($datatb) {
              $tambah_button='';
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
                $tambah_button = '<a href="'.$link.'/priviledge/'.$datatb->id.'" class="btn btn-xs btn-warning" type="submit"><i class="fa fa-edit"></i> Priviledge </a>'
                .'<div style="padding-top:10px"></div>';
                return
                 '<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-roles_id="'.$datatb->roles_id.'" data-email="'.$datatb->email.'" data-avatar="'.$datatb->avatar.'"  class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Edit</button>'
                 .'<div style="padding-top:10px"></div>'.
                 $tambah_button
                .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-roles_id="'.$datatb->roles_id.'" data-email="'.$datatb->email.'" data-avatar="'.$datatb->avatar.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
            })
            ->addIndexColumn()
            ->addColumn('Roles', function($datatb) {
              return DB::table('roles')->where('id','=',$datatb->roles_id)->first()->namaRule;
            })
            ->addColumn('avatar_images', function($datatb) {
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
              return '<img src="'.$link.$datatb->avatar.'" alt="" height="50px">';
            })
             ->make(true);
    }

    public function manageuser() {
      return view('user.userIndex');
    }

    public function getPriviledge($id) {
      //$user_roles = DB::table('users')->where('id','=',$id)->first()->roles_id;
      $menu = DB::table('frontmenu')->lists('method');
      $dashmenu = DB::table('frontmenu')->get();
      $hak_akses_array = array();
        foreach ($menu as $dtg) {
          $hak_akses_array[$dtg] = DB::table('hak_akses_user')->select('id_akses')->where('user_id','=', $id)->where('menu','=', $dtg)->orderBy('id_akses', 'asc')->get();
        }
        //dd($hak_akses_array);

      return view('user.priviledge', ['priviledge'=>$hak_akses_array, 'dashmenu'=>$dashmenu, 'id'=>$id ]);
    }

    public function RuleHakAkses(Request $request) {
      $req = $request->all();
      unset($req['_token']);
      unset($req['button']);
      $id = $request->id;
      unset($req['id']);
      $menu = DB::table('frontmenu')->lists('method');
      $hak_sebelumnya = array();
      $hak_sFormat = array();
      $arr_hak = array();
      //1=> disposition | 2 => surat rektor | 3 => sk rektor | 4 => surat warek | 5 => surat tugas warek

      //new logic goddamn
      //get dari database, kalo di database kosong langsung insert aja kelar
      if (DB::table('hak_akses_user')->where('user_id','=', $id)->count() > 0) {
        $hak_sebelumnya = array();
        foreach ($menu as $dtg) {
          //dd($dtg);
          $hak_sebelumnya[$dtg] = DB::table('hak_akses_user')->select('id_akses')
          ->where('user_id','=', $id)
          ->where('menu','=', $dtg)
          ->orderBy('id_akses', 'asc')
          ->lists('id_akses');
        }
      }
      //insert kalo di db ga ada sama sekali alias kosong
      else {
        foreach ($req as $tipe_input => $hak_input) {
          $tipe_input = explode(",",$tipe_input)[0];
          DB::table('hak_akses_user')->insert(['user_id' => $id, 'menu' => $tipe_input, 'id_akses'=>"$hak_input"]);
        }
        return Redirect::back()->with('status', 'Data has been saved');
      }

      //proses inputan jadi $arr_hak yang isinya itu menu => 1,2,3 or home => ""
      foreach ($req as $type => $hak) {
        $tp = explode(",",$type)[0];
        foreach ($menu as $dtg) {
          if ($tp == $dtg) {
            if (empty($arr_hak[$dtg])) {
               $arr_hak[$dtg] = $hak;
             } else {
               $arr_hak[$dtg] .= ','.$hak;
             }
          }
        }
      }
      foreach ($menu as $tipe) {
        if (!isset($arr_hak[$tipe])) {
          $arr_hak[$tipe] = "";
        }
        if (!isset($hak_sebelumnya[$tipe])) {
          $hak_sebelumnya[$tipe] = "";
        }
      }
      //proses
      //check, insert and delete :
      foreach ($arr_hak as $tipe => $hak2) {
       foreach ($hak_sebelumnya as $tipe_s => $hak2_s) {
          //kalo tipe sama :
          if ($tipe == $tipe_s) {
            if ($hak2 == $hak2_s) {
              //kalo hak hak sama kita continue aja karena sama coeg ga boleh di insert dua kali lah...
              continue;
            }
            else {
              //ini yang susah coeg, kita perlu liat
              $hak_arr = explode(",", $hak2);

              $diff_delete = array_diff($hak2_s,$hak_arr);
              $diff_insert = array_diff($hak_arr,$hak2_s);

              $diff_insert = array_unique($diff_insert);
              $diff_delete = array_unique($diff_delete);


              if (count($diff_delete) > 0) {
                foreach ($diff_delete as $id_akses) {
                  DB::table('hak_akses_user')->where('user_id', '=', $id)->where('menu','=',$tipe_s)->where('id_akses','=',"$id_akses")->delete();
                }
              }

              if (count($diff_insert) > 0) {
                foreach ($diff_insert as $id_akses) {
                  DB::table('hak_akses_user')->insert(
                        ['user_id' => $id, 'menu' => $tipe_s, 'id_akses'=>"$id_akses"]
                  );
                }
              }
            }
          }
        }
      }

      //return redirect('/manageuser')->with('status', 'Data Berhasil Di Simpan');
      return Redirect::back()->with('status', 'Data has been saved');

    }

    public function register(Request $request, User $user){
      //validasi request
      $this->validate($request, [
        'nama'      => 'required',
        'email'     => 'required|email|unique:users',
        'password'  => 'required|min:6',
      ]);

      //mass asignment ke database
      $createuser = $user->create([
        'nama'      => $request->nama,
        'email'     => $request->email,
        'avatar'     => $request->avatar,
        'roles_id'     => $request->roles_id,
        'password'  => bcrypt($request->password),
      ]);

      //endpoint api berdasarkan hasil dari response, jika berjalan lancar :
      // 201, artinya konten berhasil dibuat, 200 success, 404 not found, 500 server error etc etc...
      return response()->json(['sukses' => 'User Berhasil Ditambahkan !'], 201);
    }

    public function edituser(Request $request, User $user){
      //validasi request
      $this->validate($request, [
        'nama'      => 'required',
        'email'     => 'required|email',
      ]);

      $user = User::find($request->id);
      $user->email = strip_tags($request->email);
      $user->nama = strip_tags($request->nama);
      $user->avatar = strip_tags($request->avatar);
      $user->roles_id = $request->roles_id;

      if ($request->passwordnew) {
        $request->user()->fill(['password'=>Hash::make($request->passwordnew)])->save();
      }
      $user->save();


      //membuat response array, untuk di tampilkan menjadi json nantinya
      $response = array("success"=>"User Modified");
      return response()->json($response,201);
    }

    public function deleteuser(Request $request, User $user){
      $user = User::find($request->id);
      $user->delete();
      //membuat response array, untuk di tampilkan menjadi json nantinya
      $response = array("success"=>"User Deleted");

      return response()->json($response,200);
    }
    //Akhir Seksi Pengguna



    //Mulai Seksi Roles
    // .
    // .
    public function getRoles() {
      return view('roles.index');
    }

    public function rolesDataTB() {
      return Datatables::of(Role::query())
            ->addColumn('action', function ($datatb) {
                return
                '<button data-id="'.$datatb->id.'" data-namaRule="'.$datatb->namaRule.'"  class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Edit</button>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function UploadImage() {

    }

    public function editRoles(Request $request, Role $role) {
      //validasi request
      $this->validate($request, [
        'namaRule'      => 'required',
      ]);

      $roles = Role::find($request->id);
      $roles->namaRule = strip_tags($request->namaRule);
      $roles->save();

      //membuat response array, untuk di tampilkan menjadi json nantinya
      $response = array("success"=>"User Modified");
      return response()->json($response,200);
    }
    //Akhir Seksi Roles

    //Seksi Logo
    public function logoweb(){
      return view('situs.logo');
    }


    public function postImageLogo(Request $request) {
      if ($request->hasFile('tes')) {
        $namafile = $request->file('tes')->getClientOriginalName();
        $ext = $request->file('tes')->getClientOriginalExtension();
        $lokasifileskr = '/images/'.$namafile;
        $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;

        // yg paling penting cek extension, no php allowed
        if ($ext == "png" || $ext == "jpg") {
          //store
          $destinasi = public_path('../../images/');
          // dd($destinasi);
          $proses = $request->file('tes')->move($destinasi,$namafile);
          //delete foto sebelumnya jika ada....
          $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
          // if ($logo != null || $logo != "") {
          //   $file_lama = public_path($logo);
          //   unlink($file_lama);
          // }

          //update db
          $logo = SettingSitus::find('1');
          $logo->logo = $link.'/'.$lokasifileskr;

          $logo->save();
          return redirect('logodanfavicon')->with('status', 'Logo`s been updated!');
        } else {
          return Redirect::back()->withErrors(['wrong format cant be uploaded']);
        }
      } elseif ($request->hasFile('tes2')) {
        $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
        $namafile = $request->file('tes2')->getClientOriginalName();
        $ext = $request->file('tes2')->getClientOriginalExtension();
        $lokasifileskr = '/images/'.$namafile;
        // dd($namafile);
        // yg paling penting cek extension, no php allowed
        if ($ext == "png" || $ext == "jpg") {
          //store
          $destinasi = public_path('../../images/');
           // dd($destinasi);
          $proses = $request->file('tes2')->move($destinasi,$namafile);
          //delete foto sebelumnya jika ada....
          $favicon = DB::table('setting_situses')->where('id','=','1')->first()->favicon;

          //update db
          $favicon = SettingSitus::find('1');
          $favicon->favicon = $link.'/'.$lokasifileskr;
          $favicon->save();
          return redirect('logodanfavicon')->with('status', 'Favicon`s updated!');
        } else {
          return Redirect::back()->withErrors(['wrong format']);
        }
      }
    }

    public function judul(){
      return view('situs.judul');
    }

    public function updateJudulDanSlogan(Request $request) {
      $settingsitus = SettingSitus::find('1');
      $settingsitus->namaSitus = strip_tags($request->judul);
      $settingsitus->slogan = strip_tags($request->slogan);
      $settingsitus->save();
      return redirect('juduldanslogan')->with('status', 'Title and site description has been updated!');
    }

    public function getBerita() {
      return view('berita.aturBerita');
    }

    public function beritaDataTB() {
      $query = berita::with('authornya');
      return Datatables::of($query)
            ->addColumn('action', function ($datatb) {
                return
                 '<a target="_blank" style="margin-left:5px" href="/berita/'.$datatb->id_berita.'" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i> Show</a>'
                 .'<div style="padding-top:10px"></div>'
                 .'<a style="margin-left:5px" href="/berita/'.$datatb->id_berita.'/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>'
                 .'<div style="padding-top:10px"></div>'
                 .'<button style="margin-left:5px" data-id="'.$datatb->id_berita.'" data-nama="'.$datatb->judul.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
            })
            ->make(true);
    }

    public function getTambahBerita() {
      return view('berita.tambahBerita');
    }

    public function getBeritaUpdate($id) {
      $berita = berita::with('authornya')->where('id_berita','=',$id)->first();
      return view('berita.editBerita',['berita'=>$berita]);
    }

    public function updateBerita(Request $request, $id) {
      $berita = berita::find($id);
      $berita->author = Auth::User()->id;
      $berita->uri = '/berita/'.str_slug(strip_tags($request->judul));
      $berita->judul = strip_tags($request->judul);
      $berita->content = $request->content;
      $berita->save();

      $berita2 = berita::with('authornya.role')->latest()->get();
      $berita2 = response()->json($berita2);
      event(new beritaEvent($berita2));
      return redirect('berita')->with('status', 'Berita berhasil ditambahkan!');
    }

    public function postBerita(Request $request) {
      $berita = new berita();
      $berita->author = Auth::User()->id;
      $berita->uri = '/berita/'.str_slug(strip_tags($request->judul));
      $berita->judul = strip_tags($request->judul);
      $berita->content = $request->content;
      $berita->save();

      $berita2 = berita::with('authornya.role')->latest()->get();
      $berita2 = response()->json($berita2);
      event(new beritaEvent($berita2));
      return redirect('berita')->with('status', 'Berita berhasil ditambahkan!');
    }

    public function deleteBerita(Request $request) {
      $berita = berita::find($request->id_berita);
      $berita->delete();

      $berita2 = berita::with('authornya.role')->latest()->get();
      $berita2 = response()->json($berita2);
      event(new beritaEvent($berita2));

      $response = array("success"=>"Berita Deleted");
      return response()->json($response,200);
    }

    public function getKnownEmail() {
      $email = DB::table('known_email')->get();
      return view('known_email.index', ['email'=>$email]);
    }

    public function doAddKnownEmail(Request $request) {
      $tabel = new email;
      $tabel->email = $request->email;
      $tabel->nama = $request->nama;
      $tabel->save();
      $response = array("success"=>"Known Email Added");
      return response()->json($response,200);
    }

    public function doEditKnownEmail(Request $request) {
      $data = email::find($request->id);
      $data->email = $request->email;
      $data->nama = $request->nama;
      $data->save();
      $response = array("success"=>"Known Email Edited");
      return response()->json($response,200);
    }

    public function deleteKnownEmail(Request $request) {
      $data = email::find($request->id);
      $data->delete();
      $response = array("success"=>"Known Email Deleted");
      return response()->json($response,200);
    }

    public function knownEmailDataTB() {
    return Datatables::of(email::query())
          ->addColumn('action', function ($datatb) {
              return
               '<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Edit</button>'
               .'<div style="padding-top:10px"></div>'
              .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
          })
          ->make(true);
    }

    public function slideDataTB() {
      return Datatables::of(slide::query())
      ->addColumn('action', function ($datatb) {
          return
           '<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Edit</button>'
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addIndexColumn()
      ->addColumn('imagesnya', function($datatb) {
        return '<img src="'.$datatb->image.'" alt="" height="50px">';
      })
      ->make(true);
    }

    public function getFooterSetting() {
      $footer = DB::table('setting_situses')->where('id','=','1')->first();
      return view('situs.footer',['footer'=>$footer]);
    }

    public function updateFooter(Request $request) {
      $tabel = SettingSitus::find('1');
      if ($request->footer) {
        $tabel->footer = $request->footer;
      }
      if ($request->footer2) {
        $tabel->footer2 = $request->footer2;
      }
      if ($request->footer2 || $request->footer) {
        $tabel->save();
      }

      return redirect('footer')->with('status', 'Footer`s has been updated!');
    }

    public function getFront() {
      return view('front.index');
    }

    public function editFront($id) {
      $front = frontmenu::find($id);
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=',$front->method)->where('id_akses','=','1')->count() > 0) {
        return view('front.edit', ['front'=>$front]);
      } else {
        return redirect('/dashboard')->withErrors(['You dont have access!']);
      }

    }

    public function postEditFront(Request $request) {
      $data = frontmenu::find($request->id);
      if (DB::table('hak_akses_user')->where('user_id','=',Auth::User()->id)->where('menu','=',$data->method)->where('id_akses','=','3')->count() > 0) {
        $data->nama = $request->nama;
        $data->content = $request->content;
        $data->save();

        return redirect('front')->with('status', 'Front Menu '.$request->nama.' has been updated!');
      } else {
        return redirect('/dashboard')->withErrors(['You dont have acess to do that!']);
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
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" data-email="'.$datatb->email.'"  class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addIndexColumn()
      ->make(true);
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
          $response = array("success"=>"Front menu successfuly added");
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

        $response = array("success"=>"Test Gan");
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
        return redirect('/dashboard')->withErrors(['You dont have access!']);
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
        $response = array("error"=>"You dont havve acess to do that!");
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
    public function soaltb(){
      return Datatables::of(Soal::query())
      ->addColumn('action', function ($datatb) {
        $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
          return
           '<a href="'.$link.'/parameter/editsoal/'.$datatb->id.'" class="edit-modal btn btn-xs btn-info" type="submit"><i class="fa fa-edit"></i> Edit</a>'
           .'<div style="padding-top:10px"></div>'
          .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->title.'" class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
      })
      ->addIndexColumn()
      ->make(true);
    }

    public function soal(){
      return view ('soal.soal');
    }

    public function addsoal(){
      $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
      return view ('soal.addsoal')->with(compact('link'));
    }

    public function postAddSoal(Request $request){
      $soal = new Soal;
      $index = DB::table('soal')->select('index')->orderBy('id')->first();

      // dd($index);

      if($index == null){
        $soal->index = 1;
      }else{
        $a = $index->index;
        $soal->index = $a + 1;
      }
      $soal->aktif = $request->status;
      $soal->soal = $request->soal;
      $soal->change_by = Auth::User()->nama;
      // dd($soal);
      $soal->save();
      return redirect('/parameter/addsoal')->with('status', 'Data successfuly added');
    }
    public function editsoal($id){
      $manages = Soal::find($id);
      $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
      return view ('soal.editsoal')->with(compact('link','manages'));
    }
    public function updatesoal(Request $request,$id)
    {
        // dd($manage);
        $soal=Soal::find($id);
        $index = DB::table('soal')->select('index')->orderBy('id')->first();
        $a = $index->index;

        if($index == null){
          $soal->index = 1;
        }else{
          $soal->index = $a + 1;
        }
        $soal->aktif = $request->status;
        $soal->soal = $request->soal;
        // dd($soal);
        $soal->save();
        return redirect('/parameter/soal')->with('status', 'Data successfuly added');
    }
}
