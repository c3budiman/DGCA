@extends('layouts.dlayout')

@section('title')
  Changing Site Title and Description
@endsection

@section('content')
  <div class="row">
      <div class="col-12">
          <div class="card-box">
              <h4 class="header-title m-t-0">Changing Title and Description</h4>
              <p class="text-muted font-14 m-b-10">
                  You can change site`s title and description in here.
              </p>

              <form enctype="multipart/form-data" action="{{url(action("WebAdminController@updateJudulDanSlogan"))}}" method="post" class="form-horizontal ">
                  {{ csrf_field() }}
                  <div class="form-group row">
                      <label class="col-3 col-form-label">Title : </label>
                      <div class="col-9">
                          <input name="judul" type="text" required class="form-control" value="{{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}}">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-3 col-form-label">Description : </label>
                      <div class="col-9">
                          <textarea name="slogan" rows="8" cols="80" class="form-control">{{DB::table('setting_situses')->where('id','=','1')->first()->slogan}}</textarea>
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
