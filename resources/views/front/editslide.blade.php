@extends('layouts.dlayout')

@section('title')
  Editing Slider : {{$slide->title}}
@endsection

@section('content')
  <div class="row">
      <div class="col-12">
          <div class="card-box">
              <h4 class="header-title m-t-0">Editing Slider : {{$slide->title}}</h4>
              <p class="text-muted font-14 m-b-10">
                  You can change how slider {{$slide->title}} appearence here.
              </p>

              <form enctype="multipart/form-data" action="{{url(action("AdminController@putEditSlider"))}}" method="post" class="form-horizontal ">
                  {{ csrf_field() }}
                  <div class="form-group row">
                      <label class="col-3 col-form-label">Title : </label>
                      <div class="col-9">
                          <input name="title" type="text" required class="form-control" value="{{$slide->title}}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-3 col-form-label">Description : </label>
                      <div class="col-9">
                          <input name="description" type="text" required class="form-control" value="{{$slide->description}}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-3 col-form-label">Button`s title : </label>
                      <div class="col-9">
                          <input name="btn" type="text" required class="form-control" value="{{$slide->btn_title}}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-3 col-form-label">URL for button : </label>
                      <div class="col-9">
                          <input name="url" type="text" required class="form-control" value="{{$slide->link}}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-3 col-form-label">Background images</label>
                      <div class="col-9">
                          <div class="fileupload fileupload-new" data-provides="fileupload">
                              <div class="fileupload-new thumbnail" style="height: 128px;">
                                <img src="{{$slide->image}}" alt="image" />
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
                  <input type="hidden" name="id" value="{{$slide->id}}">
                  <input type="hidden" name="_method" value="PUT">
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
