
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
        <link rel="shortcut icon" href="{{ asset($favicon)}}">
        <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
        <!-- App css -->
        <link href="{{URL::asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ URL::asset('assets/js/modernizr.min.js') }}"></script>
        <!-- DataTables -->
        <link href="{{URL::asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{URL::asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert css -->
        <link href="{{URL::asset('plugins/sweet-alert/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap fileupload css -->
        <link href="{{URL::asset('plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />
        <!-- Table Responsive css -->
        <link href="{{URL::asset('plugins/responsive-table/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css" media="screen">
        <script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
    </head>
    <body class="account-pages">
        <!-- Begin page -->
        <div class="accountbg" style="background: url('../../storage/slider/a85f6f36d00b1210e3f26d61a2af181f.jpg');background-size: cover;"></div>
        <div class="wrapper-page account-page-full">
            <div class="card">
                <div class="card-block">
                    <div class="account-box">
                        <div class="card-box p-5">
                            <h2 class="text-uppercase text-center pb-4">
                                <a href="{{$link}}" class="text-success">
                                    <span><img src="{{$logo}}" alt="" width="70px"></span>
                                </a>
                            </h2>
                            <div class="pb-4">
                              <blockquote class="blockquote text-center">
                                  {{$desc}}
                                  <footer class="blockquote-footer">{{$judul}}</footer>
                              </blockquote>
                              @if (count($errors) > 0)
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                              @endif
                            </div>
                            <form class="" method="post" action="{{$link}}/password/reset">
                              {{ csrf_field() }}
                              <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group m-b-20 row">
                                    <div class="col-12">
                                        <label for="emailaddress">Alamat Email</label>
                                        <input required class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="someone@mail.com">
                                    </div>
                                </div>
                                <div class="form-group m-b-20 row">
                                    <div class="col-12">
                                        <label for="emailaddress">Password Baru</label>
                                        <input required class="form-control" type="password" name="password">
                                    </div>
                                </div>
                                <div class="form-group m-b-20 row">
                                    <div class="col-12">
                                        <label for="emailaddress">Konfirmasi Password Baru</label>
                                        <input required class="form-control" type="password" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="form-group row text-center m-t-10">
                                    <div class="col-12">
                                        <button class="btn btn-block btn-custom waves-effect waves-light" type="submit">Reset Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="account-copyright">{!!$footer!!}</p>
            </div>
        </div>
        <script src="{{ URL::asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ URL::asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ URL::asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

        <!-- KNOB JS -->
        <!--[if IE]>
        <script type="text/javascript" src="../plugins/jquery-knob/excanvas.js') }}"></script>
        <![endif]-->
        <script src="{{ URL::asset('plugins/jquery-knob/jquery.knob.js') }}"></script>
        <!-- Required datatable js -->
        <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

        @yield('js')
        <!-- Counter Up  -->
        <script src="{{ URL::asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
        <script src="{{ URL::asset('plugins/counterup/jquery.counterup.min.js') }}"></script>
        <!-- responsive-table-->
        <script src="{{ URL::asset('plugins/responsive-table/js/rwd-table.min.js') }}" type="text/javascript"></script>


        <!-- App js -->
        <script src="{{ URL::asset('assets/js/jquery.core.js') }}"></script>
        <script src="{{ URL::asset('assets/js/jquery.app.js') }}"></script>
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
