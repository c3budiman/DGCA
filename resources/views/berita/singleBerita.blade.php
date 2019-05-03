@php
  $logo = DB::table('setting_situses')->where('id','=','1')->get()->first()->logo;
@endphp

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
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
    @yield('css')
    @yield('csstambahan')
    <!-- Table Responsive css -->
    <link href="{{URL::asset('plugins/responsive-table/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css" media="screen">
    @yield('meta')
    <title>Berita | {{$berita->judul}}</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card-box task-detail">
            <div style="margin-top:5px" class="pull-right">
               <span class="badge badge-info">Pengumuman</span>
            </div>
              <div class="media mt-0 m-b-30">
                  <img class="d-flex mr-3 rounded-circle" alt="64x64" src="/images/avatar.png" style="width: 48px; height: 48px;">
                  <div class="media-body">
                      <h5 class="media-heading mb-0 mt-0">{{$berita->authornya->nama}}</h5>
                      <h5 class="text-muted">{{DB::table('roles')->where('id','=',$berita->authornya->roles_id)->get()->first()->namaRule}}</h5>
                  </div>
              </div>
              <h4 class="m-b-20">{{$berita->judul}}</h4>
              {!! $berita->content !!}
          </div>
      </div><!-- end col -->
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
  </body>
</html>
