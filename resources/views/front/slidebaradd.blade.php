@extends('layouts.dlayout')

@section('title')
  Adding new Slider
@endsection

@section('content')
  <div class="row">
      <div class="col-12">
          <div class="card-box">
              <h4 class="header-title m-t-0">Adding new slider</h4>
              <p class="text-muted font-14 m-b-10">
                  You can add slider for front end
              </p>

              <form enctype="multipart/form-data" action="{{url(action("AdminController@postAddSlidebar"))}}" method="post" class="form-horizontal ">
                  {{ csrf_field() }}
                  <div class="form-group row">
                      <label class="col-3 col-form-label">Title : </label>
                      <div class="col-9">
                          <input name="title" type="text" class="form-control" value="">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-3 col-form-label">Description : </label>
                      <div class="col-9">
                          <input name="description" type="text" class="form-control" value="">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-3 col-form-label">Background images</label>
                      <div class="col-9">
                          <div class="fileupload fileupload-new" data-provides="fileupload">
                              <div class="fileupload-new thumbnail" style="height: 128px;">
                                <img src="https://static1.squarespace.com/static/59562732f7e0ab94574ba86a/595cec37b8a79b20409a1118/5b8d3cc11ae6cf1d7df86281/1535982812270/sudarshan-bhat-102013-unsplash.jpg?format=1500w" alt="image" />
                              </div>
                              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                              <div>
                                  <button type="button" class="btn btn-custom btn-file">
                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Choose Images</span>
                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                   <input accept="image/*" type="file" class="btn-light" name="tes" id="exampleInputFile">
                                 </button>
                              </div>
                          </div>
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
