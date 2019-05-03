<html>
<head></head>
<body>
  <?php
  $footer =DB::table('setting_situses')->where('id','=','1')->first()->footer;
  $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
   ?>
<p>Perihal : Reset Password </p>
<p>Deskripsi : </p>
<p>Request untuk mereset password</p>
Silahkan
<br>
<a href="{{ url($link.'/password/reset/'.$token) }}">Klik Disini</a>
<br>
Untuk Mereset Password anda.
<br>
Jika Tidak Bekerja Silahkan Copy Link Dibawah :
<br>
 {{ url($link.'/password/reset/'.$token) }}

 <br>
 <br>
<p> <b>{{$footer}}</b> </p>
</body>
</html>
