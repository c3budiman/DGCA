<html>
<head></head>
<body>
  <?php
  $footer =DB::table('setting_situses')->where('id','=','1')->first()->footer;
   ?>
<p>Perihal : {{$sender}} </p>
<p>Deskripsi : </p>
<p>{{$pesan}}</p>

<p> <b>{{$footer}}</b> </p>
</body>
</html>
