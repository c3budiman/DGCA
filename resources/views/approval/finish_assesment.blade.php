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
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-body">
        <h2 style="vertical-align: middle; text-align: center;">Selesai Mengevaluasi UAS Assesment?</h2>
        <p style="vertical-align: middle; text-align: center;"> Assesment Yang Di Evaluasi : <a href="/detail/identitas/{{$nama_orang->id}}">{{$nama_orang->nama}}</a></p>
        <br />
        <br />
        <blockquote style="text-align: center;" class="blockquote">
          <div class="col-md-6 alert alert-middle alert-info bg-info text-white border-0" role="alert">{{$ujian_ternilai}} / {{$ujian_total}} Assesment di Evaluasi</div> <br>
          <div class="col-md-6 alert alert-middle alert-custom bg-custom text-white border-0" role="alert">
            {{$ujian_puas}} Assesment di Evaluasi Puas.
            <br>
            {{$ujian_tpuas}} Assesment di Evaluasi Tidak Puas.
            <br>
            {{$ujian_netral}} Assesment di Evaluasi Netral.
          </div> <br>
          <div class="col-md-6 alert alert-middle alert-primary bg-primary text-white border-0" role="alert">Nilai : {{$nilai_fix}} <br> Status : {{$status}}</div> <br>
          <br />

          <form style="display:inline;" action="{{url(action('AdminController@FinishUasAssesmentFix'))}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="uas_regs" value="{{$uas_regs}}">
            <a class="btn btn-danger" href="/approval/detail/uas/{{$uas_regs}}/1"><i class="fa fa-times"></i> Batal</a>
            <button class="btn btn-success" type="submit" name="button"><i class="fa fa-flag-checkered"></i> Submit</button>
          </form>

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
