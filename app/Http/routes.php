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

Route::post('tesform',function(Request $request){
    dd($request->all());
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

Route::group(['middleware' => 'auth'], function () {
   Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
   Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
});


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

//Soal
Route::get('soal/json', 'WebAdminController@soaltb')->name('soal/json');
Route::get('parameter/soal', 'WebAdminController@soal');
Route::get('parameter/addsoal', 'WebAdminController@addsoal');
Route::get('parameter/editsoal/{id}', 'WebAdminController@editsoal');
Route::put('parameter/edited/{id}','WebAdminController@updatesoal');
Route::post('parameter/postAddSoal', 'WebAdminController@postAddSoal');


/*
|--------------------------------------------------------------------------
| Admin Roles
|--------------------------------------------------------------------------
|
| Ini route buat roles admin
|
*/
Route::get('approveidentitas/json', 'AdminController@approveidentitasTB')->name('approveidentitas/json');
Route::get('approveidentitas2/json', 'AdminController@approveidentitasTB2')->name('approveidentitas2/json');
Route::get('approveidentitas', 'AdminController@approveidentitas');
Route::get('detail/identitas/{id}', 'AdminController@getidentitas');
Route::put('approvalidentitas/{id}', 'AdminController@approvedidentitas');
Route::get('approvedrones/json', 'AdminController@approvedronesTB')->name('approvedrones/json');
Route::get('approvedrones2/json', 'AdminController@approvedronesTB2')->name('approvedrones2/json');
Route::get('approvedrones', 'AdminController@approvedrones');
Route::get('detail/drones/{id}', 'AdminController@getdrones');
Route::get('detail/dronesuser/{id}', 'applicantController@getdronesuser');
Route::put('approvaldrones/{id}', 'AdminController@approveddrones');

Route::get('approval/uas', 'AdminController@getApprovalUAS');
Route::get('approvalUas/json', 'AdminController@approveUasDataTB')->name('approvalUas/json');
Route::get('approval/detail/uas/{id}/{page}', 'AdminController@getUasApprovalWithPage');
Route::get('approval/detail/uas/{id}', 'AdminController@getUasApproval');
Route::post('approval/saveKepuasan', 'AdminController@saveKepuasan');
Route::post('approval/saveketerangan', 'AdminController@saveketerangan');
Route::get('approval/detail/uas/{id}', 'AdminController@getUasApproval');
Route::get('finish_assesment/{uas_regs}', 'AdminController@getFinishAssesment');
Route::post('finish_assesment_fix', 'AdminController@FinishUasAssesmentFix');
//Route::get('approval/detail/uas/{uas_regs}','AdminController@ge')


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
Route::post('updateRemotePilot/identitas', 'applicantController@UpdateRPIdentitas');
Route::post('updateRemotePilot/alamat', 'applicantController@UpdateRPAlamatIdentitas');
Route::post('updateRemotePilot/finalisasi', 'applicantController@FinalisasiRemotePilot');
Route::post('uploadIdentitas', 'applicantController@uploadIdentitas');
Route::post('uploadIdentitas2', 'applicantController@uploadIdentitas2');
Route::post('uoloadBerkas', 'applicantController@uploadBerkas');

Route::get('nadrones/json', 'applicantController@nadronesTB')->name('nadrones/json');
Route::get('appdrones/json', 'applicantController@appdronesTB')->name('appdrones/json');
Route::get('drones','applicantController@getDrones');
Route::get('addDrones','applicantController@addDrones');
Route::get('editDrones/{id}','applicantController@editDrones');
Route::put('drones/{id}','applicantController@updateDrones');
Route::post('drones','applicantController@postDrones');
Route::post('drones/delete','applicantController@deleteDrones');
Route::post('uploadDokumenUAS', 'applicantController@uploadDokumenUAS');
Route::post('uploadPesawatSn', 'applicantController@uploadPesawatSn');
Route::post('uploadPesawat', 'applicantController@uploadPesawat');
Route::post('uploadPenguasaan', 'applicantController@uploadPenguasaan');

Route::get('uas_assesment','applicantController@getUasAssesment');
Route::get('uas_assesment_now/{id}/{id_regs}','applicantController@getSoalUjian');
Route::post('uas_assesment_now/{id}/{id_regs}','applicantController@saveJawabanAssesment');
Route::get('finish_ujian/{uas_regs}','applicantController@FinishUASA');
Route::get('finish_ujian_fix/{uas_regs}','applicantController@FinishFix');


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
