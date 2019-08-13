@extends('layouts.dlayout')

@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | Pendaftaran @endsection

@section('content')
  <style media="screen">
  #button-group {
      margin: auto;
      display: flex;
      flex-direction: row;
      justify-content: center;
    }
  </style>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-body">
        <h5 class="card-title">Approval UAS Assesment</h5>
        <p class="card-text">Isi nilai dengan tingkat kepuasaan agar dapat di approve.</p>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-2">
      <div class="card card-body">
        <h5 class="card-title">Halaman</h5>
        <div class="btn-group flex-wrap">
          @for ($i=1; $i <= $jumlah_page; $i++)
            <a href="/approval/detail/uas/{{$uas_regs}}/{{$i}}" class="btn btn-light waves-effect">{{$i}}</a>
          @endfor
        </div>
        <br>
        <div class="btn-group flex-wrap">
          <a href="/finish_ujian" class="btn btn-success">Selesai Menilai</a>
        </div>
      </div>
    </div>
    <div class="col-md-10">
      <?php $i=0; ?>
      @foreach ($soal as $soalnya)
        <?php $i++; ?>
        <div class="card m-b-30 card-body">
          <h5 class="card-title">Nomor {{$i}}</h5>
          <p class="card-text"></p>
          <div class="card-box">
            {!! $soalnya->jawaban !!}
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection

@section('js')
  <!-- Bootstrap fileupload js -->
  <script src="plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script src="plugins/select2/js/select2.min.js"></script>
  <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <script src="plugins/parsleyjs/parsley.min.js"></script>

  <script src="templateEditor/ckeditor/ckeditor.js"></script>
  <script>
    var options = {
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };
  </script>
  <script>
    CKEDITOR.replace('my-editor', options);
  </script>

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
  <script>
      $(document).ready(function() {
          $('form').parsley();
      });
  </script>
@endsection
