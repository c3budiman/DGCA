@extends('layouts.dlayout')

@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | UAS Assesment @endsection

@section('content')
  <style media="screen">
  #button-group {
      margin: auto;
      display: flex;
      flex-direction: row;
      justify-content: center;
    }
    .alert-middle {
      display: inline-block;
      line-height: normal;
    }
  </style>
  <?php
  $soal = DB::table('soal')->get();
   ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-body">
        <h1 style="vertical-align: middle; text-align: center;" class="display-3">Selesai Menilai UAS Assesment?</h1>
        <br>
        <br>
        <br>
        <blockquote style="text-align: center;" class="blockquote">
          <div class="col-md-4 alert alert-middle alert-custom bg-custom text-white border-0" role="alert">{{$ujian_ternilai}} / {{$ujian_total}} Assesment di Nilai</div> <br>
          <div class="col-md-4 alert alert-middle alert-info bg-info text-white border-0" role="alert">{{$ujian_puas}} Assesment di Nilai Puas.</div> <br>
          <div class="col-md-4 alert alert-middle alert-danger bg-danger text-white border-0" role="alert">{{$ujian_tpuas}} Assesment di Nilai Tidak Puas.</div> <br>
          <div class="col-md-4 alert alert-middle alert-warning bg-warning text-white border-0" role="alert">{{$ujian_netral}} Assesment di Nilai Netral.</div>
          <br>
          <a class="btn btn-danger" href="/approval/detail/uas/{{$uas_regs}}/1"><i class="fa fa-times"></i> Batal</a>
          <a class="btn btn-success" href="/finish_assesment_fix/{{$uas_regs}}"><i class="fa fa-flag-checkered"></i> Submit</a>
        </blockquote>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <!-- Bootstrap fileupload js -->
  <script src="{{url('/')}}/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script src="{{url('/')}}/plugins/select2/js/select2.min.js"></script>
  <script src="{{url('/')}}/plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <script src="{{url('/')}}/plugins/parsleyjs/parsley.min.js"></script>

  <!-- Sweet Alert Js  -->
  <script src="{{url('/')}}/plugins/sweet-alert/sweetalert2.min.js"></script>

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
  <script>
      $(document).ready(function() {
          $('form').parsley();
      });
  </script>
@endsection
