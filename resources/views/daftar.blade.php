<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>UG - SISTEM MANAJEMEN SURAT</title>
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
        <script src="assets/js/modernizr.min.js"></script>
    </head>
    <body class="account-pages">
        <!-- Begin page -->
        <div class="accountbg" style="background: url('gambar/slide01.jpg');background-size: cover;"></div>
        <div class="wrapper-page account-page-full">
            <div class="card">
                <div class="card-block">
                    <div class="account-box">
                        <div class="card-box p-5">
                            <h2 class="text-uppercase text-center pb-4">
                                <a href="index.html" class="text-success">
                                    <span><img src="gambar/logo-gunadarma.png" alt="" height="100"></span>
                                </a>
                            </h2>
                            <div class="pb-4">
                              <blockquote class="blockquote text-center">
                                  <footer class="blockquote-footer">UG - SISTEM MANAJEMEN SURAT</footer>
                              </blockquote>
                            </div>
                            <form method="post" class="form-horizontal" action="{{url(action('regisController@postRegis'))}}">
                            {{ csrf_field() }}

                              <div class="form-group row m-b-20">
                                  <div class="col-12">
                                      <label for="username">Nama Lengkap</label>
                                      <input name="nama" class="form-control" type="text" id="username" required placeholder="Michael Zenaty">
                                  </div>
                              </div>

                              <div class="form-group row m-b-20">
                                  <div class="col-12">
                                      <label for="emailaddress">Email</label>
                                      <input name="email" class="form-control" type="email" id="emailaddress" required placeholder="john@deo.com">
                                  </div>
                              </div>

                              <div class="form-group row m-b-20">
                                  <div class="col-12">
                                      <label for="emailaddress">url Avatar</label>
                                      <input name="avatar" class="form-control" type="text" id="no_telp" required placeholder="No Telepon">
                                  </div>
                              </div>

                              <div class="form-group row m-b-20">
                                  <div class="col-12">
                                      <label for="password">Password</label>
                                      <input name="password" class="form-control" type="password" required="" id="password" placeholder="Enter your password">
                                  </div>
                              </div>

                              {{-- <div class="form-group row m-b-20">
                                  <div class="col-12">
                                      <div class="checkbox checkbox-custom">
                                          <input id="remember" type="checkbox" checked="">
                                          <label for="remember">
                                              I accept <a href="#" class="text-custom">Terms and Conditions</a>
                                          </label>
                                      </div>
                                  </div>
                              </div> --}}

                              <div class="form-group row text-center m-t-10">
                                  <div class="col-12">
                                      <button class="btn btn-block btn-custom waves-effect waves-light" type="submit">Sign Up Free</button>
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
                <p class="account-copyright"><?php echo date("Y"); ?> GUCC © UG - Sistem Manajemen Surat.</p>
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
