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
| Auto Crud
|--------------------------------------------------------------------------
|
| Ini route generate an dari auto crud
|
*/
Route::resource('cars', 'carController');

Route::resource('homes', 'homeController');
Route::get('home', 'guestController@index');
Route::get('home/json', 'homeController@dataTB');
Route::get('home/{method}', 'homeController@viewSubmenu');

Route::resource('whoweares', 'whoweareController');
Route::get('whoweare', 'whoweareController@getFront');
Route::get('whoweare/json', 'whoweareController@dataTB');
//tambahan dari klien, redirect langsung yg overview ke menu utama.
Route::get('whoweare/overview', 'whoweareController@getFront');
Route::get('whoweare/{method}', 'whoweareController@viewSubmenu');


Route::resource('ourfocusas', 'ourfocusaController');
Route::get('ourfocusa', 'ourfocusaController@getFront');
Route::get('ourfocusa/json', 'ourfocusaController@dataTB');
Route::get('ourfocusa/{method}', 'ourfocusaController@viewSubmenu');

Route::resource('our_services', 'our_serviceController');
Route::get('our_service', 'our_serviceController@getFront');
Route::get('our_service/json', 'our_serviceController@dataTB');
Route::get('our_service/{method}', 'our_serviceController@viewSubmenu');

Route::resource('partners', 'partnerController');
Route::get('partner', 'partnerController@getFront');
Route::get('partner/json', 'partnerController@dataTB');
Route::get('partner/{method}', 'partnerController@viewSubmenu');

Route::resource('news_digests', 'news_digestController');
Route::get('news_digest', 'news_digestController@getFront');
Route::get('news_digest/json', 'news_digestController@dataTB');
Route::get('news_digest/{method}', 'news_digestController@viewSubmenu');

Route::resource('contacts', 'contactController');
Route::get('contact', 'contactController@getFront');
Route::get('contact/json', 'contactController@dataTB');
Route::get('contact/{method}', 'contactController@viewSubmenu');
Route::resource('tews', 'tewController');
Route::get('tew', 'tewController@getFront');
Route::get('tew/json', 'tewController@dataTB');
Route::get('tew/{method}', 'tewController@viewSubmenu');
Route::resource('our_teams', 'our_teamController');
Route::get('our_team', 'our_teamController@getFront');
Route::get('our_team/json', 'our_teamController@dataTB');
Route::get('our_team/{method}', 'our_teamController@viewSubmenu');

Route::resource('whowearepages', 'whowearepagesController');
Route::get('whowearepages', 'whowearepagesController@getFront');
Route::get('whowearepages/json', 'whowearepagesController@dataTB');
Route::get('whowearepages/{method}', 'whowearepagesController@viewSubmenu');

Route::resource('pageswhoweares', 'pageswhoweareController');
Route::get('pageswhoweare', 'pageswhoweareController@getFront');
Route::get('pageswhoweare/json', 'pageswhoweareController@dataTB');
Route::get('pageswhoweare/{method}', 'pageswhoweareController@viewSubmenu');

Route::resource('pagesourmissions', 'pagesourmissionController');
Route::get('pagesourmission', 'pagesourmissionController@getFront');
Route::get('pagesourmission/json', 'pagesourmissionController@dataTB');
Route::get('pagesourmission/{method}', 'pagesourmissionController@viewSubmenu');

Route::resource('pageshowwemakechanges', 'pageshowwemakechangesController');
Route::get('pageshowwemakechanges', 'pageshowwemakechangesController@getFront');
Route::get('pageshowwemakechanges/json', 'pageshowwemakechangesController@dataTB');
Route::get('pageshowwemakechanges/{method}', 'pageshowwemakechangesController@viewSubmenu');

Route::resource('pageshowwemakechanges', 'pageshowwemakechangeController');
Route::get('pageshowwemakechange', 'pageshowwemakechangeController@getFront');
Route::get('pageshowwemakechange/json', 'pageshowwemakechangeController@dataTB');
Route::get('pageshowwemakechange/{method}', 'pageshowwemakechangeController@viewSubmenu');

Route::resource('homes', 'homeController');
Route::get('home', 'homeController@getFront');
Route::get('home/json', 'homeController@dataTB');
Route::get('home/{method}', 'homeController@viewSubmenu');

Route::resource('berandas', 'berandaController');
Route::get('beranda', 'berandaController@getFront');
Route::get('beranda/json', 'berandaController@dataTB');
Route::get('beranda/{method}', 'berandaController@viewSubmenu');

Route::resource('homes', 'homeController');
Route::get('home', 'homeController@getFront');
Route::get('home/json', 'homeController@dataTB');
Route::get('home/{method}', 'homeController@viewSubmenu');

Route::resource('homes', 'homeController');
Route::get('home', 'homeController@getFront');
Route::get('home/json', 'homeController@dataTB');
Route::get('home/{method}', 'homeController@viewSubmenu');

Route::resource('faqs', 'faqController');
Route::get('faq', 'faqController@getFront');
Route::get('faq/json', 'faqController@dataTB');
Route::get('faq/{method}', 'faqController@viewSubmenu');

Route::resource('galleries', 'galleryController');
Route::get('gallery', 'galleryController@getFront');
Route::get('gallery/json', 'galleryController@dataTB');
Route::get('gallery/{method}', 'galleryController@viewSubmenu');

Route::resource('pelayanans', 'pelayananController');
Route::get('pelayanan', 'pelayananController@getFront');
Route::get('pelayanan/json', 'pelayananController@dataTB');
Route::get('pelayanan/{method}', 'pelayananController@viewSubmenu');

Route::resource('kontaks', 'kontakController');
Route::get('kontak', 'kontakController@getFront');
Route::get('kontak/json', 'kontakController@dataTB');
Route::get('kontak/{method}', 'kontakController@viewSubmenu');
