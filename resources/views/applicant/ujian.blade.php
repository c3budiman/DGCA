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
        <h5 class="card-title">EVALUATION OF UAS OPERATION</h5>
        <p class="card-text">Harap Isi dengan Keadaan Sesungguhnya, Jika Sudah Selesai, Harap Menekan Akhiri Pada Tabular Pilihan Soal</p>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-2">
      <div class="card card-body">
        <h5 class="card-title">Nomor Soal</h5>
        <div class="btn-group flex-wrap">
          <?php $i=0; ?>
          @foreach ($all_soal as $soalnya)
            <?php $i++; ?>
            @if ($i === $current_soal->id)
              <a href="/uas_assesment_now/{{$soalnya->id}}/{{$id_regs}}" class="btn btn-light waves-effect active">{{$i}}</a>
            @else
              @if ($soalnya->jawaban == null)
                <a href="/uas_assesment_now/{{$soalnya->id}}/{{$id_regs}}" class="btn btn-light waves-effect">{{$i}}</a>
              @else
                <a href="/uas_assesment_now/{{$soalnya->id}}/{{$id_regs}}" class="btn btn-secondary waves-light waves-effect">{{$i}}</a>
              @endif
            @endif
          @endforeach
        </div>
        <br>
        <div class="btn-group flex-wrap">
          <a href="/finish_ujian/{{$id_regs}}" class="btn btn-danger"><i class="fa fa-flag-checkered"></i> Submit Assesment</a>
        </div>
      </div>
    </div>
    <div class="col-md-10">
      <div class="card m-b-30 card-body">
        <h5 class="card-title">Nomor {{$current_soal->id}}</h5>
        <p class="card-text">{!! $current_soal->soal !!}</p>
        <div class="card-box">
          <form enctype="multipart/form-data" action="{{url('/')}}/uas_assesment_now/{{$current_soal->id}}/{{$id_regs}}" method="post" class="form-horizontal ">
              {{ csrf_field() }}
              <div class="form-group row">
                  <div class="col-12">
                    <textarea cols="10" rows="10" id="my-editor" name="jawaban" class="form-control">{!! $all_soal[$current_soal->id - 1]->jawaban !!}</textarea>
                  </div>
              </div>
              <div class="pull-right">
                  <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> Next</button>
              </div>
          </form>
        </div>
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

  <script src="{{url('/')}}/templateEditor/ckeditor/ckeditor.js"></script>
  <script>
    var options = {
      filebrowserImageBrowseUrl: '{{url('/')}}/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '{{url('/')}}/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '{{url('/')}}/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '{{url('/')}}/laravel-filemanager/upload?type=Files&_token='
    };
  </script>
  <script>
    CKEDITOR.replace('my-editor', options);
  </script>

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
