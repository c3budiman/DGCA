@extends('layouts.dlayout')
@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} || {{DB::table('roles')->where('id','=','1')->first()->namaRule}} Dashboard @endsection

@section('content')
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['User Roles', 'Total'],
            ['{{DB::table('roles')->where('id','=','1')->first()->namaRule}}',     {{DB::table('users')->where('roles_id','=','1')->count()}}],
            ['{{DB::table('roles')->where('id','=','2')->first()->namaRule}}',     {{DB::table('users')->where('roles_id','=','2')->count()}}]
          ]);

          var options = {
            title: 'User Statistic',
            is3D: true,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
          chart.draw(data, options);
        }
  </script>


<div class="content">
  <div class="container-fluid">
    {{-- <div class="row">
        <div class="col-md-12">
            Welcome! <br> there is nothing to show here yet... check back later...
        </div>
    </div> --}}
    <!-- end row -->
    <div class="row text-center">
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card-box widget-flat border-success bg-success text-white">
                <i class="fa fa-envelope"></i>
                <h3 class="m-b-10">{{DB::table('frontmenu')->count()}}</h3>
                <p class="text-uppercase m-b-5 font-13 font-600">Frontmenu</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card-box bg-primary widget-flat border-primary text-white">
                <i class="fa fa-user"></i>
                <h3 class="m-b-10">{{DB::table('users')->where('roles_id','=','1')->count()}}</h3>
                <p class="text-uppercase m-b-5 font-13 font-600">{{DB::table('roles')->where('id','=','1')->first()->namaRule}}</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card-box widget-flat border-custom bg-custom text-white">
                <i class="fa fa-user-secret"></i>
                <h3 class="m-b-10">{{DB::table('users')->where('roles_id','=','2')->count()}}</h3>
                <p class="text-uppercase m-b-5 font-13 font-600">{{DB::table('roles')->where('id','=','2')->first()->namaRule}}</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card-box bg-danger widget-flat border-danger text-white">
                <i class="fa fa-institution"></i>
                <h3 class="m-b-10">{{DB::table('users')->count()}}</h3>
                <p class="text-uppercase m-b-5 font-13 font-600">Registered User</p>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div style="width: 900px; height: 500px;" class="chart mt-4" id="piechart_3d" ></div>
        </div>
    </div>
    <!-- end row -->
  </div>
</div>


@endsection


@section('jstambahan')


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

@endsection
