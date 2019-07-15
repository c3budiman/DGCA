@extends('layouts.dlayout')

@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | Pendaftaran @endsection

@section('content')
  <style media="screen">
  .parsley-errors-list > li:before {
    display: none;
  }
  </style>
  <link href="plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
  <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <?php
    $status = DB::table('user_step')->where('user_id', Auth::User()->id)->first()->kode_status;
   ?>
  @if ($status == 2)
    <form enctype="application/x-www-form-urlencoded" data-parsley-validate id="example-advanced-form" action="{{url(action('applicantController@postIdentitas'))}}" method="post">
        {{ csrf_field() }}
        <h3>Identitas Pemohon</h3>
        <fieldset>
          <?php //dd(Auth::User()) ?>
        <legend>Pemohon (Applicant)</legend>
            <div class="form-group">
              <label for="name">Nama Pemohon (Applicant Name) <span class="text-danger">*</span></label>
              <input value="{{ Auth::User()->nama }}" parsley-trigger="change" data-parsley-group="block1" type="text" name="nama" class="form-control" id="name" required>
            </div>
            <div class="form-group">
              <label for="company">Nama Perusahaan (Company)<span class="text-danger">*</span></label>
               <input type="text" name="company" parsley-trigger="change" data-parsley-group="block1" value="{{ Auth::User()->company }}" class="form-control" id="company" required>
             </div>
            <div class="form-group">
              <label for="phone">No Telepon (Phone)<span class="text-danger">*</span></label>
              <input name="phone" type="text" parsley-trigger="change" data-parsley-group="block1" data-parsley-type="number" data-parsley-minlength="10" data-parsley-maxlength="13" placeholder="08xxxxxxxxxx" class="form-control" required>
            </div>
        <p>(*) Mandatory</p>
        </fieldset>

        <h3>Alamat Pemohon</h3>
        <fieldset>
            <div class="form-group">
              <label for="address">Provinsi (Province)<span class="text-danger">*</span></label>
              <div class="col-sm-10">
                <select id="provinsi" class="form-control provinsi" name="provinsi" data-placeholder="Silahkan Pilih..." onchange="selectRegency()">
                    <?php $table = DB::table('provinces')->get(); ?>
                      <option value="">Silahkan Pilih...</option>
                    @foreach ($table as $row)
                      <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="address">Kabupaten/Kota(City)<span class="text-danger">*</span></label>
              <div class="col-sm-10">
                <select id="regency" class="form-control regency" name="regency" data-placeholder="Silahkan Pilih..." onchange="selectDistrict()">
                  <option value="">Silahkan pilih provinsi terlebih dahulu...</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="address">Kecamatan(district)<span class="text-danger">*</span></label>
              <div class="col-sm-10">
                <select id="district" class="form-control district" name="district" data-placeholder="Silahkan Pilih..." onchange="selectVillage()">
                  <option value="">Silahkan pilih Kabupaten/Kota terlebih dahulu...</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="address">Desa/Kelurahan(villages)<span class="text-danger">*</span></label>
              <div class="col-sm-10">
                <select id="village" class="form-control village" name="village" data-placeholder="Silahkan Pilih...">
                  <option value="">Silahkan pilih Kecamatan terlebih dahulu...</option>
                </select>
              </div>
            </div>

            <p>(*) Mandatory</p>
        </fieldset>

        <h3>Dokumen</h3>
        <fieldset>
          <div class="form-group row">
              <label class="col-3 col-form-label">Tanda Pengenal (KTP/SIMP/Passport)</label>
              <div class="col-3">
                  <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
                      <div class="fileupload-new thumbnail" style=" height: 128px;">
                        <img src="/gambar/ktp.jpg" alt="image">
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                          <button type="button" class="btn btn-custom btn-file">
                           <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Choose Picture</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                           <input accept="image/*" type="file" class="btn-light" name="upload_doc" id="upload_doc">
                         </button>
                         <br>
                         <br>
                      <input id="uploadImage" type="button" value="Upload Image" name="upload"></div>
                  </div>
              </div>
              <div class="col-3">
              	<i id="CheckListIdentitas" style="color:green; font-size:30px; display:none;" class="fa fa-check"> </i>
              </div>
          </div>
        </fieldset>

        <h3>Finish</h3>
        <fieldset>
            <legend>Terms and Conditions</legend>

            <input id="acceptTerms-2" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
        </fieldset>
    </form>

    @elseif ($status == 1)
      <div class="row">
        <div class="col-md-12">
          <div class="card-box">
              <center> <h1 class="display-4">Silahkan Memverifikasi Email Terlebih Dahulu!</h1> </center>
          </div>
        </div>
      </div>
    @else
      <div class="row">
        <div class="col-md-12">
          <div class="card-box">
            <center> <h1 class="display-4">Anda Telah Mendaftarkan Identitas Anda</h1> </center>

          </div>
        </div>
      </div>

  @endif



@endsection

@section('js')

  <!-- Bootstrap fileupload js -->
  <script src="plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script src="plugins/select2/js/select2.min.js"></script>
  <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <script src="plugins/parsleyjs/parsley.min.js"></script>


  <script type="text/javascript">
  var form = $("#example-advanced-form").show();
  var provinsi = $('#provinsi').val();
  var regency = $('#regency').val();
  var district = $('#district').val();

  <?php
    $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
  ?>

  function selectRegency() {
    if ($('#provinsi').val() != "") {
      $('#regency').select2({
        ajax: {
          url: '{{url('/')."/regency/"}}'+$('#provinsi').val(),
          data: function (params) {
            var query = {
              search: params.term,
            }
            return query;
          },
          processResults: function (data) {
             return {
               results: data.map((e)=> {
                 return {text:e.name, id:e.id};
               })
             };
          }
        }
      });
    }
  }

  function selectDistrict() {
    if ($('#regency').val() != "") {
      $('#district').select2({
        ajax: {
          url: '{{url('/')."/district/"}}'+$('#regency').val(),
          data: function (params) {
            var query = {
              search: params.term,
            }
            return query;
          },
          processResults: function (data) {
             return {
               results: data.map((e)=> {
                 return {text:e.name, id:e.id};
               })
             };
          }
        }
      });
    }
  }

  function selectVillage() {
    if ($('#district').val() != "") {
      $('#village').select2({
        ajax: {
          url: '{{url('/')."/village/"}}'+$('#district').val(),
          data: function (params) {
            var query = {
              search: params.term,
            }
            return query;
          },
          processResults: function (data) {
             return {
               results: data.map((e)=> {
                 return {text:e.name, id:e.id};
               })
             };
          }
        }
      });
    }
  }

  $(document).ready(function() {
      $('.provinsi').select2();

      $("#uploadImage").click(function(e){
        $('#CheckListIdentitas').hide()
        var uploadedFile = new FormData();
        uploadedFile.append('upload_doc', upload_doc.files[0]);
        uploadedFile.append('_token', $('input[name=_token]').val());
        $.ajax({
            type: "POST",
            url: '{{url(action('applicantController@uploadIdentitas'))}}',
            dataType: "json",
            processData: false, // important
            contentType: false, // important
            data: uploadedFile,
            success: function (data, status) {
              $('#CheckListIdentitas').show()
            },
            error: function (error) {
                alert('Kesalahan Saat Upload')
                console.log(error);
            }
        });
      });
  });

  form.steps({
      headerTag: "h3",
      bodyTag: "fieldset",
      transitionEffect: "slideLeft",
      onStepChanging: function (event, currentIndex, newIndex)
      {
          // Allways allow previous action even if the current form is not valid!
          if (currentIndex > newIndex)
          {
              return true;
          }
          // Forbid next action if the users has wrong input!
          if (newIndex === 1 && ! $('form').parsley().validate({group: 'block1', force: true}) )
          {
              return false;
          }
          if (newIndex === 2 && ! $('form').parsley().validate({group: 'block2', force: true}) )
          {
              return false;
          }
          // Needed in some cases if the user went back (clean up)
          if (currentIndex < newIndex)
          {
              // To remove error styles
              form.find(".body:eq(" + newIndex + ") label.error").remove();
              form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
          }
          // form.validate().settings.ignore = ":disabled,:hidden";
          return true;
      },
      onStepChanged: function (event, currentIndex, priorIndex)
      {
          // Used to skip the "Warning" step if the user is old enough.
          if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
          {
              form.steps("next");
          }
          // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
          if (currentIndex === 2 && priorIndex === 3)
          {
              form.steps("previous");
          }
      },
      onFinishing: function (event, currentIndex)
      {
          document.getElementById("example-advanced-form").submit();// Form submission
          form.validate().settings.ignore = ":disabled";
          return form.valid();
      },
      onFinished: function (event, currentIndex)
      {
          alert("Submitted!");
      }
  });
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

  <script type="text/javascript">

  </script>

  <script type="text/javascript">
    // jQuery.noConflict();
    // jQuery('#uploadImage').on("click", function (e) {
    //       var uploadedFile = new FormData();
    //       uploadedFile.append('upload_doc', upload_doc.files[0]);
    //       jQuery.ajax({
    //         url: '{{url(action('applicantController@uploadIdentitas'))}}',
    //         type: 'POST',
    //         processData: false, // important
    //         contentType: false, // important
    //         dataType : 'json',
    //         data: {
    //           'upload_doc' : uploadedFile,
    //           '_token'     : $('input[name=_token]').val()
    //         }
    //       });
    // });
  </script>
@endsection
