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

  <form data-parsley-validate id="example-advanced-form" action="/tesform" method="post">
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
            <input id="pass1" type="text" parsley-trigger="change" data-parsley-group="block1" data-parsley-type="number" data-parsley-minlength="10" data-parsley-maxlength="13" placeholder="08xxxxxxxxxx" class="form-control" required>
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
            <label for="address">Kabupaten/Kota (City)<span class="text-danger">*</span></label>
            <div class="col-sm-10">
              <select id="regency" class="form-control regency" name="regency" data-placeholder="Silahkan Pilih..." onchange="selectDistrict()">

              </select>
            </div>
          </div>
          {{-- <div class="form-group">
            <label for="address">Kabupaten/Kota (City)<span class="text-danger">*</span></label>
            <input type="text" data-parsley-group="block2" required placeholder="Depok" class="form-control" id="passWord2">
          </div> --}}
          <div class="form-group">
            <label for="address">Kecamatan (sub-district)<span class="text-danger">*</span></label>
            <input type="text" data-parsley-group="block2" required placeholder="Beji" class="form-control" id="passWord2">
          </div>
          <div class="form-group">
            <label for="address">Jalan dan Kelurahan (Streets)<span class="text-danger">*</span></label>
            <input type="text" data-parsley-group="block2" required placeholder="Kelurahan x Jalan x no x rt x rw x" class="form-control" id="passWord2">
          </div>

          <p>(*) Mandatory</p>
      </fieldset>

      <h3>Dokumen</h3>
      <fieldset>
        <div class="form-group row">
            <label class="col-3 col-form-label">Tanda Pengenal (KTP/SIMP/Passport)</label>
            <div class="col-9">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" style=" height: 128px;">
                        @if (Auth::User()->ktp != null || Auth::User()->ktp != "")
                        <img src="{{Auth::User()->avatar}}" alt="image" /> @else
                        <img src="/gambar/ktp.jpg" alt="image" /> @endif
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
      </fieldset>

      <h3>Finish</h3>
      <fieldset>
          <legend>Terms and Conditions</legend>

          <input id="acceptTerms-2" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
      </fieldset>
  </form>
@endsection

@section('js')
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
      console.log($('#provinsi').val());
      $(document).ready(function() {
          $('.provinsi').select2(

          );
      });
    }
  }

  $(document).ready(function() {
      $('.provinsi').select2();
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
  }).validate({
      errorPlacement: function errorPlacement(error, element) { element.before(error); },
      rules: {
          confirm: {
              equalTo: "#password-2"
          }
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
@endsection
