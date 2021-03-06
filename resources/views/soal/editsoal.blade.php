@extends('layouts.dlayout')

@section('title')
  Adding Soal UAS Assessment
@endsection

@section('editsoal')
  <div class="row">
      <div class="col-12">
          <div class="card-box">
              <h4 class="header-title m-t-0">Editing question</h4>
              <p class="text-muted font-14 m-b-10">
                  You can edit question
              </p>
              <form enctype="multipart/form-data" action="/parameter/edited/{{$manages->id}}" method="post" class="form-horizontal ">
                <input type="hidden" name="_method" value="put">
                  {{ csrf_field() }}
                  <div class="form-group row">
                      <label class="col-3 col-form-label">Soal : </label>
                      <div class="col-9">
                      <textarea cols="10" rows="10" id="my-editor" name="soal">{{ $manages-> soal}}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-3 col-form-label">Status : </label>
                      <div class="col-9">
                        <select required class="form-control" name="status" data-placeholder="Silahkan Pilih...">
                          <option value="">Silahkan Pilih...</option>
                          <option value="Aktif">Aktif</option>
                          <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>

                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-12">
                          <div class="pull-right">
                              <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <!--  end row -->
@endsection

@section('jstambahan')
<!-- Bootstrap fileupload js -->
<script src="{!! asset('plugins/bootstrap-fileupload/bootstrap-fileupload.js') !!} "></script>
<!-- Sweet Alert Js  -->
<script src="{!! asset('plugins/sweet-alert/sweetalert2.min.js') !!}"></script>
<script src="{!! asset('templateEditor/ckeditor/ckeditor.js') !!}"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '{{$link}}/filemanager?type=Images',
    filebrowserImageUploadUrl: '{{$link}}/filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '{{$link}}/filemanager?type=Files',
    filebrowserUploadUrl: '{{$link}}/filemanager/upload?type=Files&_token='
  };
</script>
<script>
$(document).ready(function() {
   $('#my-editor').show();
   CKEDITOR.replace('my-editor', options);
    });
</script>
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
                        title: 'success!',
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
