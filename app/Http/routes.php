<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| ini buat nge config laravel, dan ngejalanin pembersihan cache
| serta manggil php artisan tanpa harus akses ssh
|
*/
use Carbon\Carbon;
use App\tesmenu;
use Illuminate\Http\Request;

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});


//experimental crud generator :
// Route::get('/CrudGenerator', function() {
//     $exitCode = Artisan::call('make:command', ['name' => 'CrudGenerator']);
//     return '<h1>Command Generated</h1>';
// });

Route::get('/makecrud', function() {
    $exitCode = Artisan::call('crud:generator', ['name' => 'submenu']);
    return '<h1>Crud Generated</h1>';
});

//symlink
//u need to specify basepath for laravel, and base public_html
Route::get('/link', function() {
    symlink(base_path('public/photos'), base_path('../photos'));
    symlink(base_path('public/files'), base_path('../files'));
    return '<h1>Link created</h1>';
});

Route::get('/link2', function() {
    symlink(base_path('public/files'), base_path('../files'));
    return '<h1>Link created</h1>';
});

Route::get('slide/json', 'AdminController@slideDataTB')->name('slide/json');
Route::get('cars/add', 'authController@getCars');

Route::post('tesform',function(Request $request){
  dd($request->all());
});

Route::get('/tesgan22', function() {
  return Datatables::of(tesmenu::query())
  ->addColumn('action', function ($datatb) {
      $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
      return
       '<a target="_blank" href="'.$link.'/'.$datatb->link.'" class="edit-modal btn btn-xs btn-success" ><i class="fa fa-eye"></i> View</a>'
       .'<div style="padding-top:10px"></div>'
       .'<a href="'.$link.'/tesmenu/editsub/'.$datatb->id.'" class="edit-modal btn btn-xs btn-info" ><i class="fa fa-edit"></i> Edit</a>'
       .'<div style="padding-top:10px"></div>'
      .'<button data-id="'.$datatb->id.'" data-nama="'.$datatb->nama.'" class="delete-modal btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>';
  })
  ->addIndexColumn()
  ->make(true);
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| ini routes untuk guest, alias yang belum login
| routes ini meliputi login, daftar, ajax dll
|
*/

Route::get('/', 'guestController@index');
Route::get('dashboard', 'authController@getRoot');
Route::get('daftar', 'regisController@getRegis');
Route::post('daftar', 'regisController@postRegis');
Route::get('verif/{token}','regisController@doverif');

Route::get('login', ['as' => 'login', 'uses' => 'loginController@getlogin']);
Route::post('login', 'loginController@postLogin');
Route::get('logout', 'authController@logout');

// Password reset link request routes...
Route::get('lupa_password', 'Auth\PasswordController@getEmail');
Route::post('lupa_password', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


/*
|--------------------------------------------------------------------------
| Auth Roles
|--------------------------------------------------------------------------
|
| Ini route buat yang udah login aja any roles
|
*/
//@auth user
Route::get('myprofile', 'authController@getMyProfile');
Route::get('editprofile', 'authController@getEditProfile');
Route::put('editprofile', 'authController@UpdateProfile');
Route::get('support', 'authController@getSupport');

Route::get('pages/index', 'authController@getAturIndex');
Route::get('managefiles', 'authController@getAturFiles');
Route::get('manageimages', 'authController@getAturPhotos');


/*
|--------------------------------------------------------------------------
| Super Admin Roles
|--------------------------------------------------------------------------
|
| Ini route buat roles Super admin
|
*/
// Sidebar Part
Route::get('sidebarsettings', 'WebAdminController@getSidebarSetting');
Route::post('addsidebar', 'WebAdminController@tambahSidebarAjax');
Route::get('sidebar/json', 'WebAdminController@sidebarDataTB')->name('sidebar/json');
Route::get('sidebar/{id}/edit', 'WebAdminController@editSidebar');
Route::post('sidebar/delete', 'WebAdminController@deleteSidebar');
Route::get('submenu/json/{id}', 'WebAdminController@submenuDataTB')->name('submenu/json/{id}');
Route::put('sidebar/{id}', 'WebAdminController@updateSidebar');
Route::post('addsubmenu', 'WebAdminController@PostAddSubmenu');
Route::post('deletesubmenu', 'WebAdminController@deleteSubmenu');
Route::post('editsubmenu', 'WebAdminController@editsubmenu');

Route::get('logodanfavicon', 'WebAdminController@logoweb');
Route::put('logodanfavicon', 'WebAdminController@postImageLogo');
Route::get('juduldanslogan', 'WebAdminController@judul');
Route::put('juduldanslogan', 'WebAdminController@updateJudulDanSlogan');
Route::get('footer', 'WebAdminController@getFooterSetting');
Route::put('footer', 'WebAdminController@updateFooter');

//Berita Part
Route::get('berita', 'WebAdminController@getBerita');
Route::get('berita/json', 'WebAdminController@beritaDataTB')->name('berita/json');
Route::get('tambahBerita', 'WebAdminController@getTambahBerita');
Route::post('berita', 'WebAdminController@postBerita');
Route::post('delete/berita', 'WebAdminController@deleteBerita');
Route::get('berita/{id}/edit','WebAdminController@getBeritaUpdate');
Route::put('berita/{id}/edit', 'WebAdminController@updateBerita');

//User SPA get and ajax part :
Route::get('user/json', 'WebAdminController@userDataTB')->name('user/json');
Route::get('manageuser', 'WebAdminController@manageuser');
Route::post('auth/register','WebAdminController@register');
Route::post('auth/edituser','WebAdminController@edituser');
Route::post('auth/delete','WebAdminController@deleteuser');
Route::get('priviledge/{iduser}', 'WebAdminController@getPriviledge');
Route::post('priviledge/post', 'WebAdminController@RuleHakAkses');

//roles
Route::get('roles', 'WebAdminController@getRoles');
Route::get('roles/json', 'WebAdminController@rolesDataTB')->name('roles/json');
Route::post('roles/edit', 'WebAdminController@editRoles');

Route::get('front','AdminController@getFront');
Route::get('front/json', 'AdminController@frontDataTB')->name('front/json');
Route::post('front','AdminController@postFront');
Route::get('front/edit/{id}', 'AdminController@editFront');
Route::put('front/edit', 'AdminController@postEditFront');
Route::post('front/edit', 'AdminController@postEditFront2');
Route::get('front/{id}/editadvance','AdminController@getEditFrontAdvance');
Route::post('deleteFront', 'AdminController@deleteFront');

Route::get('{method}/editsub/{id}', 'AdminController@EditSubmenuFront');
Route::post('deletesub/{method}', 'AdminController@deleteSubmenuFront');

Route::put('submenufront/edit','AdminController@EditSubmenuFrontPost');

Route::get('news/json', 'news_digestController@dataTB2')->name('news/json');
Route::get('news_digest/add', 'news_digestController@getAddNews');
Route::get('news_digest/edit/{id}','news_digestController@getEditNews');
Route::post('news_digest/post', 'news_digestController@postNews');
Route::put('news_digest/put', 'news_digestController@putNews');
Route::post('news_digest/delete', 'news_digestController@deleteNews');
Route::get('news_digests/id/{id}', 'news_digestController@getFrontNews');

Route::get('slider/add', 'AdminController@getAddSlidebar');
Route::post('slider/add', 'AdminController@postAddSlidebar');
Route::get('edit/slide/{id}', 'AdminController@getEditSlider');
Route::put('edit/slide', 'AdminController@putEditSlider');
Route::post('slider/delete','AdminController@deleteSlider');



/*
|--------------------------------------------------------------------------
| Admin Roles
|--------------------------------------------------------------------------
|
| Ini route buat roles admin
|
*/

Route::get('known-email/json', 'WebAdminController@knownEmailDataTB')->name('known-email/json');
Route::get('known-email', 'WebAdminController@getKnownEmail');
Route::get('known-email/add', 'WebAdminController@addKnownEmail');
Route::post('known-email/add', 'WebAdminController@doAddKnownEmail');
Route::get('known-email/edit/{id}', 'WebAdminController@editKnownEmail');
Route::post('known-email/doedit', 'WebAdminController@doEditKnownEmail');
Route::post('known-email/delete', 'WebAdminController@deleteKnownEmail');


/*
|--------------------------------------------------------------------------
| Api Wilayah
|--------------------------------------------------------------------------
|
| Ini route buat api wilayah
|
*/

Route::get('provinsi/{nama}', 'apiController@getProvinsi');
Route::get('regency/{id}', 'apiController@getRegency');
Route::get('district/{id}', 'apiController@getDistrict');
Route::get('village/{id}', 'apiController@getVillage');


/*
|--------------------------------------------------------------------------
| Applicant Routes
|--------------------------------------------------------------------------
|
| Ini route pengguna atau applicant atau pengaju
|
*/
Route::get('identitas','applicantController@getIdentitas');
Route::post('identitas','applicantController@postIdentitas');
Route::post('uploadIdentitas', 'applicantController@uploadIdentitas');
Route::post('uoloadBerkas', 'applicantController@uploadBerkas');

Route::get('drones','applicantController@getDrones');
Route::post('drones','applicantController@postDrones');
Route::post('uploadDokumenUAS', 'applicantController@uploadDokumenUAS');
Route::post('uploadPesawatSn', 'applicantController@uploadPesawatSn');
Route::post('uploadPesawat', 'applicantController@uploadPesawat');
Route::post('uploadPenguasaan', 'applicantController@uploadPenguasaan');


/*
|--------------------------------------------------------------------------
| Auto Crud
|--------------------------------------------------------------------------
|
| Ini route generate an dari auto crud
|
*/
Route::resource('homes', 'homeController');
Route::get('home', 'homeController@getFront');
Route::get('home/json', 'homeController@dataTB');
Route::get('home/{method}', 'homeController@viewSubmenu');

Route::resource('pendaftarans', 'pendaftaranController');
Route::get('pendaftaran', 'pendaftaranController@getFront');
Route::get('pendaftaran/json', 'pendaftaranController@dataTB');
Route::get('pendaftaran/{method}', 'pendaftaranController@viewSubmenu');
Route::resource('homes', 'homeController');
Route::get('home', 'homeController@getFront');
Route::get('home/json', 'homeController@dataTB');
Route::get('home/{method}', 'homeController@viewSubmenu');

Route::resource('pendaftarans', 'pendaftaranController');
Route::get('pendaftaran', 'pendaftaranController@getFront');
Route::get('pendaftaran/json', 'pendaftaranController@dataTB');
Route::get('pendaftaran/{method}', 'pendaftaranController@viewSubmenu');
Route::resource('homes', 'homeController');
Route::get('home', 'homeController@getFront');
Route::get('home/json', 'homeController@dataTB');
Route::get('home/{method}', 'homeController@viewSubmenu');

Route::resource('pendaftarans', 'pendaftaranController');
Route::get('pendaftaran', 'pendaftaranController@getFront');
Route::get('pendaftaran/json', 'pendaftaranController@dataTB');
Route::get('pendaftaran/{method}', 'pendaftaranController@viewSubmenu');
