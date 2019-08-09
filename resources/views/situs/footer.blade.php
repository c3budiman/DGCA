@extends('layouts.dlayout')

@section('title')
  Changing Site Title and Description
@endsection

@section('content')
  <div class="row">
      <div class="col-12">
          <div class="card-box">
              <h4 class="header-title m-t-0">Changing Footer Appearence</h4>
              <p class="text-muted font-14 m-b-10">
                  You can change site`s Footer Appearence in here.
              </p>

              <form enctype="multipart/form-data" action="{{url(action("WebAdminController@updateFooter"))}}" method="post" class="form-horizontal ">
                  {{ csrf_field() }}
                  <div class="form-group row">
                      <label class="col-3 col-form-label">Footer Copyright : </label>
                      <div class="col-9">
                          <input name="footer" type="text" required class="form-control" value="{{DB::table('setting_situses')->where('id','=','1')->first()->footer}}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-3 col-form-label">Main Footer : </label>
                      <div class="col-9">
                          <textarea cols="10" rows="10" id="my-editor" name="footer2" class="form-control">{{DB::table('setting_situses')->where('id','=','1')->first()->footer2}}</textarea>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-12">
                          <div class="pull-right">
                              <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                          </div>
                      </div>
                  </div>
                  <input type="hidden" name="_method" value="PUT">
              </form>
          </div>
      </div>
  </div>
  <!--  end row -->
@endsection

@section('jstambahan')

  <script src="templateEditor/ckeditor/ckeditor.js"></script>
  <script>
    var options = {
      filebrowserImageBrowseUrl: '/starlingresource/filemanager?type=Images',
      filebrowserImageUploadUrl: '/starlingresource/filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '/starlingresource/filemanager?type=Files',
      filebrowserUploadUrl: '/starlingresource/filemanager/upload?type=Files&_token='
    };
  </script>
  <script>
    CKEDITOR.replace('my-editor', options);
  </script>

<!-- Bootstrap fileupload js -->
<script src="plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
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
