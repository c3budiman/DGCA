<html>
<head></head>
<body>
  <?php
  $footer =DB::table('setting_situses')->where('id','=','1')->first()->footer;
  $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
   ?>
<p>Perihal : Verifikasi Akun </p>
Silahkan
<br>
<a href="{{ url($link.'/verif/'.$user->verif_token) }}">Klik Disini</a>
<br>
Untuk Memverifikasi akun anda.
<br>
Jika Tidak Bekerja Silahkan Copy Link Dibawah :
<br>
 {{ url($link.'/verif/'.$user->verif_token) }}

 <br>
 <br>
<p> <b>{!!$footer!!}</b> </p>
</body>
</html>
