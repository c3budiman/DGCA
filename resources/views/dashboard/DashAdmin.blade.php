@extends('layouts.dlayout')
@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} || {{DB::table('roles')->where('id','=','1')->first()->namaRule}} Dashboard @endsection

@section('content')
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link href="../plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
  <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['User Roles', 'Total'],
            ['{{DB::table('roles')->where('id','=','2')->first()->namaRule}}',     {{DB::table('users')->where('roles_id','=','2')->count()}}],
            ['{{DB::table('roles')->where('id','=','3')->first()->namaRule}}',     {{DB::table('users')->where('roles_id','=','3')->count()}}],
            ['{{DB::table('roles')->where('id','=','4')->first()->namaRule}}',     {{DB::table('users')->where('roles_id','=','4')->count()}}]
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
                <i class="fa fa-id-card"></i>
                <h3 class="m-b-10">{{DB::table('remote_pilot')->where('status',1)->count()}}</h3>
                <p class="text-uppercase m-b-5 font-13 font-600">Lisensi Remote Pilot Aktif</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card-box bg-primary widget-flat border-primary text-white">
                <i class="fa fa-rocket"></i>
                <h3 class="m-b-10">{{DB::table('registered_drone')->where('status',1)->count()}}</h3>
                <p class="text-uppercase m-b-5 font-13 font-600">Lisensi Drones Aktif</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card-box widget-flat border-custom bg-custom text-white">
                <i class="fa fa-institution"></i>
                <h3 class="m-b-10">{{DB::table('perusahaan')->where('approved',1)->count()}}</h3>
                <p class="text-uppercase m-b-5 font-13 font-600">Perusahaan Aktif</p>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card-box bg-danger widget-flat border-danger text-white">
                <i class="fa fa-users"></i>
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
      <div class="col-md-6">
          <div class="card-box">
              <h4 class="header-title">Heat Map Pendaftar</h4>
              <div id="indonesia" style="height: 500px"></div>
          </div>
      </div>
      <div class="col-md-6">
          <div style="width: 100%; height: 500px;" class="chart mt-4" id="piechart_3d" ></div>
      </div>

    </div>
    <!-- end row -->
  </div>
  </div>


@endsection


@section('jstambahan')

  <script src="../plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-id-id.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <script src="../plugins/jvectormap/gdp-data.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-uk-mill-en.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-au-mill.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-us-il-chicago-mill-en.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-ca-lcc.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-de-mill.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-in-mill.js"></script>
  <script src="../plugins/jvectormap/jquery-jvectormap-asia-mill.js"></script>
  <script src="assets/pages/jquery.jvectormap.init.js"></script>
  <div class="jvectormap-tip" style="display: none; left: 767.969px; top: 2625px;">Indonesia</div>
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

  <script type="text/javascript">
  ! function($) {
    "use strict";

    var VectorMap = function() {
    };

    var gdpData = {
      //aceh
      "ID_ac": {{DB::table('users')->where('address','like','%ACEH%')->count()}},
      //Bangka Belitung
      "ID_bb": {{DB::table('users')->where('address','like','%BANGKA BELITUNG%')->count()}},
      //Bengkulu
      "ID_be": {{DB::table('users')->where('address','like','%BENGKULU%')->count()}},
      //Bali
      "ID_ba": {{DB::table('users')->where('address','like','%BALI%')->count()}},
      //banten
      "ID_bt": {{DB::table('users')->where('address','like','%BANTEN%')->count()}},
      //Gorontalo
      "ID_go": {{DB::table('users')->where('address','like','%GORONTALO%')->count()}},
      //Jambi
      "ID_ja": {{DB::table('users')->where('address','like','%JAMBI%')->count()}},
      //Jakarta
      "ID_jk": {{DB::table('users')->where('address','like','%JAKARTA%')->count()}},
      //Jawa Barat
      "ID_jb": {{DB::table('users')->where('address','like','%JAWA BARAT%')->count()}},
      //Jawa Timur
      "ID_jl": {{DB::table('users')->where('address','like','%JAWA TIMUR%')->count()}},
      //Jawa Tengah
      "ID_jt": {{DB::table('users')->where('address','like','%JAWA TENGAH%')->count()}},
      //kalimantan Barat
      "ID_kb": {{DB::table('users')->where('address','like','%KALIMANTAN BARAT%')->count()}},
      //Kalimantan Timur
      "ID_ki": {{DB::table('users')->where('address','like','%KALIMANTAN TIMUR%')->count()}},
      //Kepulauan Riau
      "ID_kr": {{DB::table('users')->where('address','like','%KEPULAUAN RIAU%')->count()}},
      //kalimantan selatan
      "ID_ks": {{DB::table('users')->where('address','like','%KALIMANTAN SELATAN%')->count()}},
      //kalimantan tengah
      "ID_kt": {{DB::table('users')->where('address','like','%KALIMANTAN TENGAH%')->count()}},
      //kalimantan utara
      "ID_ku": {{DB::table('users')->where('address','like','%KALIMANTAN UTARA%')->count()}},
      //Lampung
      "ID_la": {{DB::table('users')->where('address','like','%LAMPUNG%')->count()}},
      //Sumatera barat
      "ID_sb": {{DB::table('users')->where('address','like','%SUMATERA BARAT%')->count()}},
      //Maluku
      "ID_ma": {{DB::table('users')->where('address','like','%MALUKU%')->count()}},
      //Maluku Utara
      "ID_mu": {{DB::table('users')->where('address','like','%MALUKU UTARA%')->count()}},
      //Nusa Tenggara Barat
      "ID_nb": {{DB::table('users')->where('address','like','%NUSA TENGGARA BARAT%')->count()}},
      //Nusa Tenggara Timur
      "ID_nt": {{DB::table('users')->where('address','like','%NUSA TENGGARA TIMUR%')->count()}},
      //Papua
      "ID_pa": {{DB::table('users')->where('address','like','%PAPUA%')->count()}},
      //Papua Barat
      "ID_pb": {{DB::table('users')->where('address','like','%PAPUA BARAT%')->count()}},
      //Riau
      "ID_ri": {{DB::table('users')->where('address','like','%RIAU%')->count()}},
      //Sulawesi Utara
      "ID_sa": {{DB::table('users')->where('address','like','%SULAWESI UTARA%')->count()}},
      //Sulawesi Tenggara
      "ID_sg": {{DB::table('users')->where('address','like','%SULAWESI TENGGARA%')->count()}},
      //Sumatera Selatan
      "ID_sn": {{DB::table('users')->where('address','like','%SUMATERA SELATAN%')->count()}},
      //Sulawesi Barat
      "ID_sr": {{DB::table('users')->where('address','like','%SULAWESI BARAT%')->count()}},
      //Sulawesi Selatan
      "ID_ss": {{DB::table('users')->where('address','like','%SULAWESI SELATAN%')->count()}},
      //Sulawesi tengah
      "ID_st": {{DB::table('users')->where('address','like','%SULAWESI TENGAH%')->count()}},
      //Sumatera Utara
      "ID_su": {{DB::table('users')->where('address','like','%SUMATERA UTARA%')->count()}},
      //Yogyakarta
      "ID_yo": {{DB::table('users')->where('address','like','%DI YOGYAKARTA%')->count()}},
      //Timor Leste
      "tl": 0,
      //malay and brunei
      "my_sb": 0,
      "my_sr": 0,
      "bn": 0,
    };

    VectorMap.prototype.init = function() {
      $('#indonesia').vectorMap({
        map : 'id_ID',
        series: {
          regions: [{
            values: gdpData,
            scale: ['#C8EEFF', '#0071A4'],
            normalizeFunction: 'polynomial'
          }]
        },
        onRegionTipShow: function(e, el, code){
          el.html(el.html()+' ('+gdpData[code]+' Pendaftar)');
        },
        backgroundColor : 'transparent',
        regionStyle : {
          initial : {
            fill : '#02c0ce'
          }
        }
      });
    },
    //init
    $.VectorMap = new VectorMap, $.VectorMap.Constructor =
    VectorMap
  }(window.jQuery),

  //initializing
  function($) {
    "use strict";
    $.VectorMap.init()
  }(window.jQuery);
  </script>

@endsection
