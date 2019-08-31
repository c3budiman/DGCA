<!DOCTYPE html>
<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
  $judul = DB::table('setting_situses')->where('id','=','1')->first()->namaSitus;
  $favicon =DB::table('setting_situses')->where('id','=','1')->first()->favicon;
  $footer =DB::table('setting_situses')->where('id','=','1')->first()->footer;
  $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
  $desc = DB::table('setting_situses')->where('id','=','1')->first()->slogan;
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>{{$judul}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{{ asset('images/favicon.png') }}}">
        <!-- Sweet Alert css -->
        <link href="plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css">
        <script src="assets/js/modernizr.min.js"></script>
    </head>
    <body class="account-pages">
        <!-- Begin page -->
        <div class="accountbg" style="background: url('/storage/slider/a85f6f36d00b1210e3f26d61a2af181f.jpg');background-size: cover;"></div>
        <div class="wrapper-page account-page-full">
            <div class="card">
                <div class="card-block">
                    <div class="account-box">
                        <div class="card-box p-5">
                          <h2 class="text-uppercase text-center pb-4" style="margin-top:-30px">
                              <a href="{{$link}}" class="text-success">
                                  <span><img src="{{$logo}}" alt="" width="70px"></span>
                              </a>
                          </h2>
                          <div class="pb-4" style="margin-top:-30px">
                            <blockquote class="blockquote text-center">
                                {{$desc}}
                                <footer class="blockquote-footer">{{$judul}}</footer>
                            </blockquote>
                            </div>
                            <form method="post" class="form-horizontal" action="{{url(action('regisController@postRegis'))}}">
                            {{ csrf_field() }}

                              <div class="form-group row m-b-20">
                                  <div class="col-12">
                                      <label for="username">Nama Lengkap</label>
                                      <input name="nama" class="form-control" type="text" id="username" required placeholder="Budiman Wahid">
                                  </div>
                              </div>

                              @if ($_GET['reg'] == "bisnis")
                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <label for="emailaddress">Perusahaan</label>
                                        <select id="perusahaan" class="form-control perusahaan" name="perusahaan" required>
                                            <?php $table = DB::table('perusahaan')->where('approved',1)->get(); ?>
                                              <option value="">Silahkan Pilih...</option>
                                            @foreach ($table as $row)
                                              <option value="{{$row->id}}">{{$row->nama_perusahaan}}</option>
                                            @endforeach
                                        </select>

                                        <a href="/daftar_perusahaan" class="text-muted float-right"><small>Perusahaan Belum Terdaftar?</small></a>
                                    </div>
                                </div>
                              @endif

                              <div class="form-group row m-b-20">
                                  <div class="col-12">
                                      <label for="emailaddress">Email</label>
                                      <input name="email" class="form-control" type="email" id="emailaddress" required placeholder="someone@mail.com">
                                  </div>
                              </div>

                              <div class="form-group row m-b-20">
                                  <div class="col-12">
                                      <label for="password">Password</label>
                                      <input name="password" class="form-control" type="password" required="" id="password" placeholder="password">
                                  </div>
                              </div>

                              <input type="hidden" name="tipe" value="{{$_GET['reg']}}">

                              <div class="form-group row text-center m-t-10">
                                  <div class="col-12">
                                      <button class="btn btn-block btn-custom waves-effect waves-light" type="submit">Daftar</button>
                                  </div>
                              </div>

                          </form>
                            {{-- <div class="row m-t-50">
                                <div class="col-sm-12 text-center">
                                    <p class="text-muted">Don't have an account? <a href="page-register.html" class="text-dark m-l-5"><b>Sign Up</b></a></p>
                                </div>
                            </div> --}}

                        </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="account-copyright">{!!$footer!!}</p>
            </div>
        </div>
        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="plugins/select2/js/select2.min.js"></script>
        <script type="text/javascript">
          $(document).ready(function () {
              $('#perusahaan').select2();
          });
        </script>
        <script src="assets/js/jquery.app.js"></script>
          <!-- Sweet Alert Js  -->
          <script src="plugins/sweet-alert/sweetalert2.min.js"></script>
          @if (session('status'))
            <script type="text/javascript">
            !function ($) {
              "use strict";
              var SweetAlert = function () {
              };
              SweetAlert.prototype.init = function () {
                  $(document).ready(function () {
                      swal(
                          {
                              title: 'Sukses!',
                              text: '{{ session('status') }}',
                              type: 'success',
                              confirmButtonClass: 'btn btn-confirm mt-2'
                          }
                      )
                  });
                },
             $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
                  }(window.jQuery),
                    function ($) {
                        "use strict";
                        $.SweetAlert.init()
                    } (window.jQuery);
            </script>
          @endif

          @if($errors->any())
          <script type="text/javascript">
          !function ($) {
            "use strict";
            var SweetAlert = function () {
            };
            SweetAlert.prototype.init = function () {
                $(document).ready(function () {
                    swal(
                        {
                            title: 'Error!',
                            text: '{{$errors->first()}}',
                            type: 'error',
                            confirmButtonClass: 'btn btn-confirm mt-2'
                        }
                    )
                });
              },
           $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
                }(window.jQuery),
                  function ($) {
                      "use strict";
                      $.SweetAlert.init()
                  } (window.jQuery);
          </script>
          @endif
    </body>
</html>
