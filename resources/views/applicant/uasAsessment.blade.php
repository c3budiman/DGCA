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
  <?php
  $soal = DB::table('soal')->get();
   ?>
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
          @foreach ($soal as $soalnya)
            <?php $i++; ?>
            @if ($i === 1)
              <a href="/uas_assesment_now/{{$soalnya->id}}/{{$uas_regs->id}}" class="btn btn-light waves-effect active">{{$i}}</a>
            @else
              <a href="/uas_assesment_now/{{$soalnya->id}}/{{$uas_regs->id}}" class="btn btn-light waves-effect">{{$i}}</a>
            @endif
          @endforeach
        </div>
        <br>
        <div class="btn-group flex-wrap">
          <a href="/finish_ujian" class="btn btn-success">Finish Assesment</a>
        </div>
      </div>
    </div>
    <div class="col-md-10">
      <div class="card m-b-30 card-body">
        <h5 class="card-title">Nomor 1</h5>
        <p class="card-text">{!! $soal[3]->soal !!}</p>
        <div class="card-box">
          <form enctype="multipart/form-data" action="{{url(action("WebAdminController@postBerita"))}}" method="post" class="form-horizontal ">
              {{ csrf_field() }}
              <div class="form-group row">
                  <div class="col-12">
                    <textarea cols="10" rows="10" id="my-editor" name="content" class="form-control"></textarea>
                  </div>
              </div>
              <div class="pull-right">
                  <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
              </div>
          </form>
        </div>
      </div>
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
