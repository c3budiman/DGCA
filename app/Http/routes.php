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
use CodeItNow\BarcodeBundle\Utils\QrCode;

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

// Route::get('/makecrud', function() {
//     $exitCode = Artisan::call('crud:generator', ['name' => 'submenu']);
//     return '<h1>Crud Generated</h1>';
// });

//symlink
//u need to specify basepath for laravel, and base public_html
// Route::get('/link', function() {
//     symlink(base_path('public/photos'), base_path('../photos'));
//     symlink(base_path('public/files'), base_path('../files'));
//     return '<h1>Link created</h1>';
// });
//
// Route::get('/link2', function() {
//     symlink(base_path('public/files'), base_path('../files'));
//     return '<h1>Link created</h1>';
// });

Route::post('tesform',function(Request $request){
    dd($request->all());
});

// Route::get('rollback_alamat', function() {
//   $user = DB::table('users')->get();
//   foreach ($user as $usr) {
//     if ($usr->address) {
//       $alamat_real = $usr->address;
//       $alamat_kode = explode("\,", $alamat_real);
//       // dd($alamat_kode);
//       echo DB::table('provinces')->where('name',ltrim($alamat_kode[3], ' '))->first()->id;
//       echo "<br>";
//       echo DB::table('regencies')->where('name',ltrim($alamat_kode[1], ' '))->first()->id;
//       echo "<br>";
//       echo DB::table('districts')->where('name',ltrim($alamat_kode[2], ' '))->first()->id;
//       echo "<br>";
//       echo DB::table('villages')->where('name',ltrim($alamat_kode[0], ' '))->first()->id;
//       echo "<br>";
//       DB::table('users')
//             ->where('id', $usr->id)
//             ->update([ 'address_code' => DB::table('regencies')->where('name',ltrim($alamat_kode[1], ' '))->first()->id ] );
//       echo $usr->email;
//       echo "<br>";
//
//
//     }
//   }
// });
//
// Route::get('rollback_company', function() {
//   $user = DB::table('users')->get();
//   foreach ($user as $usr) {
//     if ($usr->company) {
//       if (DB::table('perusahaan')->where('id',$usr->company)->count() > 0) {
//         continue;
//       } else {
//         if ($usr->company == 'n/a') {
//           DB::table('users')
//                 ->where('id', $usr->id)
//                 ->update( [ 'company' => 2 ] );
//         } else {
//           DB::table('users')
//                 ->where('id', $usr->id)
//                 ->update( [ 'company' => 3 ] );
//         }
//       }
//     } else {
//       DB::table('users')
//             ->where('id', $usr->id)
//             ->update( [ 'company' => 3 ] );
//     }
//   }
// });



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

//login :
Route::get('login', ['as' => 'login', 'uses' => 'loginController@getlogin']);
Route::post('login', 'loginController@postLogin');
//logout :
Route::get('logout', 'authController@logout');
// Password reset link request routes...
Route::get('lupa_password', 'Auth\PasswordController@getEmail');
Route::post('lupa_password', 'Auth\PasswordController@postEmail');
// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


//daftar perusahaan :
Route::get('daftar_perusahaan', 'regisController@getRegisPerusahaan');
Route::post('daftar_perusahaan', 'regisController@postDaftarPerusahaan');

Route::get('drone/confirm/{id}', 'guestController@GetVerifDrone');
Route::get('remote_pilot/confirm/{id}', 'guestController@GetVerifRemotePilot');



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
| Api Routes
|--------------------------------------------------------------------------
|
| ini routes untuk api nyambungin ke airmap.
| routes ini meliputi login dan akses data dengan token.
|
*/
//Route::post('api/v2/login', 'loginController@authenticate');
Route::group(['middleware' => 'auth.login'], function() {
  Route::post('api/login','loginController@authenticate');
});

Route::group(['middleware' => 'auth.token'], function () {
    Route::post('user/tes', 'Api2Controller@tesadmin');
    Route::get('user/tes2', 'Api2Controller@tesadmin2');
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
Route::put('approvaldrones/{id}', 'AdminController@approveddrones');

Route::get('approval/uas', 'AdminController@getApprovalUAS');
Route::get('approvalUas/json', 'AdminController@approveUasDataTB')->name('approvalUas/json');
Route::get('approvalUasFinish/json', 'AdminController@approvedUasDataTB')->name('approvalUasFinish/json');
Route::get('approval/detail/uas/{id}/{page}', 'AdminController@getUasApprovalWithPage');
Route::get('approval/detail/uas/{id}', 'AdminController@getUasApproval');
Route::post('approval/saveKepuasan', 'AdminController@saveKepuasan');
Route::post('approval/saveketerangan', 'AdminController@saveketerangan');
Route::get('approval/detail/uas/{id}', 'AdminController@getUasApproval');
Route::get('finish_assesment/{uas_regs}', 'AdminController@getFinishAssesment');
Route::post('finish_assesment_fix', 'AdminController@FinishUasAssesmentFix');
Route::get('detail/uas/finished/{id}', 'AdminController@UasApprovalFinished');
//Route::get('approval/detail/uas/{uas_regs}','AdminController@ge')

Route::get('approval/company', 'AdminController@getApprovalCompany');
Route::get('approval/company/json', 'AdminController@approvalCompanyJson')->name('approval/company/json');

Route::get('approval/detail/company/{id}','AdminController@getDetailCompany');
Route::put('approval/perusahaan/{id}', 'AdminController@ApproveCompany');
Route::get('approved/company/json', 'AdminController@approvedCompanyJson')->name('approved/company/json');


Route::get('manage/perusahaan', 'AdminController@getManagePerusahaan');
Route::get('approved/company/json/{id}', 'AdminController@approvedCompanyJson2')->name('approved/company/json/{id}');

Route::get('manage/company/json', 'AdminController@manageCompanyJson')->name('manage/company/json');
Route::get('manage/company/json/{id}', 'AdminController@manageCompanyJson2');
Route::post('manage/company/approve','AdminController@ApproveUsertoCompanyByAdmin');







/*
|--------------------------------------------------------------------------
| Admin Perusahaan Routes
|--------------------------------------------------------------------------
|
| ini routes untuk admin perusahaan,
| routes ini meliputi pendaftaran identitas perusahaan, dan penambahan anggota admin perusahaan
|
*/
Route::get('perusahaan', 'AdminPerusahaanController@getIsianPerusahaan');
Route::post('perusahaan', 'AdminPerusahaanController@SaveIsianPerusahaan');
Route::post('perusahaan/dokumen', 'AdminPerusahaanController@UploadDokumenPerusahaan');
Route::get('perusahaan/approval/anggota','AdminPerusahaanController@getApprovalAnggotaPerusahaan');
Route::get('manage/self/json', 'AdminPerusahaanController@manageCompanyJson')->name('manage/self/json');
Route::get('detail/identitas/adminperu/{id}', 'AdminPerusahaanController@getidentitas');
Route::post('manage/self/approve','AdminPerusahaanController@ApproveUsertoCompanyByAdmin');
Route::post('manage/self/remove','AdminPerusahaanController@RemoveUserFromCompany');

Route::get('perusahaan/anggota','AdminPerusahaanController@getAnggotaPerusahaan');
Route::get('manage/anggota/json', 'AdminPerusahaanController@manageAnggotaJson')->name('manage/anggota/json');

Route::get('perusahaan/adrones/json', 'AdminPerusahaanController@nadronesTB')->name('perusahaan/nadrones/json');
Route::get('perusahaan/appdrones/json', 'AdminPerusahaanController@appdronesTB')->name('perusahaan/appdrones/json');
Route::get('perusahaan/companyDrones/json', 'AdminPerusahaanController@companyDronesDataTB')->name('perusahaan/companyDrones/json');

Route::get('perusahaan/drones','AdminPerusahaanController@getDrones');
Route::get('perusahaan/addDrones','AdminPerusahaanController@addDrones');
Route::get('perusahaan/editDrones/{id}','AdminPerusahaanController@editDrones');

Route::post('perusahaan/drones','AdminPerusahaanController@postDrones');
Route::post('perusahaan/drones/delete','AdminPerusahaanController@deleteDrones');
Route::put('perusahaan/drones/{id}','AdminPerusahaanController@updateDrones');
Route::post('perusahaan/drones/{id}','AdminPerusahaanController@updateDrones');

Route::post('perusahaan/uploadDokumenUAS', 'AdminPerusahaanController@uploadDokumenUAS');
Route::post('perusahaan/uploadPesawatSn', 'AdminPerusahaanController@uploadPesawatSn');
Route::post('perusahaan/uploadPesawat', 'AdminPerusahaanController@uploadPesawat');
Route::post('perusahaan/uploadPenguasaan', 'AdminPerusahaanController@uploadPenguasaan');

Route::get('detail/dronecompuser/{id}', 'AdminPerusahaanController@getdronesuser2');



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
Route::get('companyDrones/json', 'applicantController@companyDronesDataTB')->name('companyDrones/json');
Route::get('drones','applicantController@getDrones');
Route::get('addDrones','applicantController@addDrones');
Route::get('editDrones/{id}','applicantController@editDrones');
Route::post('drones','applicantController@postDrones');
Route::post('drones/delete','applicantController@deleteDrones');
Route::put('drones/{id}','applicantController@updateDrones');
Route::post('drones/{id}','applicantController@updateDrones');
Route::get('detail/dronesuser/{id}', 'applicantController@getdronesuser');
Route::post('uploadDokumenUAS', 'applicantController@uploadDokumenUAS');
Route::post('uploadPesawatSn', 'applicantController@uploadPesawatSn');
Route::post('uploadPesawat', 'applicantController@uploadPesawat');
Route::post('uploadPenguasaan', 'applicantController@uploadPenguasaan');

Route::get('uas_assesment','applicantController@getUasAssesment');
Route::get('uas_assesment_now/{id}/{id_regs}','applicantController@getSoalUjian');
Route::post('uas_assesment_now/{id}/{id_regs}','applicantController@saveJawabanAssesment');
Route::get('finish_ujian/{uas_regs}','applicantController@FinishUASA');
Route::get('finish_ujian_fix/{uas_regs}','applicantController@FinishFix');

Route::get('changeCompany','applicantController@getPindahPerusahaan');
Route::post('changeCompany','applicantController@doPindahPerusahaan');


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
