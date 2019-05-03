@extends('layouts.dlayout')
@section('title') Editing {{Auth::User()->nama}}'s Profile @endsection



@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="header-title m-t-0">Editing {{Auth::User()->nama}}'s Profile</h4>
            <p class="text-muted font-14 m-b-10">
                You can change name, photos, email, and password in here.
            </p>

            <form enctype="multipart/form-data" action="{{url(action("authController@UpdateProfile"))}}" method="post" class="form-horizontal ">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-3 col-form-label">Photos</label>
                    <div class="col-9">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 128px; height: 128px;">
                                @if (Auth::User()->avatar != null || Auth::User()->avatar != "")
                                <img src="{{Auth::User()->avatar}}" alt="image" /> @else
                                <img src="http://via.placeholder.com/128x128" alt="image" /> @endif
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            <div>
                                <button type="button" class="btn btn-custom btn-file">
                                 <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Choose Picture</span>
                                 <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                 {{-- poto profil is here : --}}
                                 <input accept="image/*" type="file" class="btn-light" name="tes" id="exampleInputFile">
                               </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-3 col-form-label">Name</label>
                    <div class="col-9">
                        <input name="nama" type="text" required class="form-control" value="{{Auth::User()->nama}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-3 col-form-label">Email</label>
                    <div class="col-9">
                        <input name="email" type="email" required class="form-control" value="{{Auth::User()->email}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-3 col-form-label">New Password</label>
                    <div class="col-9">
                        <input id="password1" name="password1" type="password" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-3 col-form-label">Password Confirmation</label>
                    <div class="col-9">
                        <input id="password2" name="password2" type="password" class="form-control" value="">
                        <br>
                        <p id="validate-status"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="pull-right">
                            <button id="simpan" type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
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
  <script type="text/javascript">
  $(document).ready(function() {
    $("#password2").keyup(validate);
  });


  function validate() {
    var password1 = $("#password1").val();
    var password2 = $("#password2").val();
      if(password1 == password2) {
         //valid
         $("#password2").css("background-color", "#0acf97");
         $("#password1").css("background-color", "#0acf97");
         $("#validate-status").text("password ok!");
         $("#simpan").prop('disabled', false);
      }
      else if (password2 == '') {
        $("#password1").css("background-color", "");
        $("#password2").css("background-color", "");
        $("#validate-status").text("");
        $("#simpan").prop('disabled', false);
      }
      else {
        $("#password2").css("background-color", "#ff3333");
        $("#password1").css("background-color", "#ff3333");
        $("#validate-status").text("password tidak sama!");
        $("#simpan").prop('disabled', true);
      }

  }
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
