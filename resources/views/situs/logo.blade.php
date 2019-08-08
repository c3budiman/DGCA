@extends('layouts.dlayout')

@section('title')
  Website`s Logo and Favicon Settings
@endsection

@section('content')
  <div class="row">
      <div class="col-12">
          <div class="card-box">
              <h4 class="header-title m-t-0">Managing Logo and Favicon</h4>
              <p class="text-muted font-14 m-b-10">
                  in this menu, you can change logo and favicon for your site
              </p>

              <form enctype="multipart/form-data" action="{{url(action("WebAdminController@postImageLogo"))}}" method="post" class="form-horizontal ">
                  {{ csrf_field() }}
                  <div class="form-group row">
                      <label class="col-3 col-form-label">Logo Situs</label>
                      <div class="col-9">
                          <div class="fileupload fileupload-new" data-provides="fileupload">
                              <div class="fileupload-new thumbnail" style="height: 128px;">
                                <?php
                                  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
                                ?>
                                  @if ($logo != null || $logo != "")
                                  <img src="{{$logo}}" alt="image" /> @else
                                  <img src="/images/logosimple.png" alt="image" /> @endif
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
                          <div class="form-group row">
                              <div class="col-12">
                                  <div class="pull-right">
                                      <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <hr>
                  <div class="form-group row">
                      <label class="col-3 col-form-label">Favicon Situs</label>
                      <div class="col-9">
                          <div class="fileupload fileupload-new" data-provides="fileupload">
                              <div class="fileupload-new thumbnail" style="height: 128px;">
                                <?php
                                  $logo = DB::table('setting_situses')->where('id','=','1')->first()->favicon;
                                ?>
                                  @if ($logo != null || $logo != "")
                                  <img src="{{$logo}}" alt="image" /> @else
                                  <img src="/images/logosimple.png" alt="image" /> @endif
                              </div>
                              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                              <div>
                                  <button type="button" class="btn btn-custom btn-file">
                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Choose images</span>
                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                   <input accept="image/*" type="file" class="btn-light" name="tes2" id="exampleInputFile">
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
