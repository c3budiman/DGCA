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
  @if ($status == 3)
    <form enctype="multipart/form-data" data-parsley-validate id="example-advanced-form" action="{{url(action('applicantController@postDrones'))}}" method="post">
        {{ csrf_field() }}
        <h3>Dokumen Registrasi (DGCA Registration Documents)</h3>
        <fieldset>
          <div class="form-group row">
              <div class="col-2">
                <label>Copy Bukti Kepemilikan</label>
                <i id="CheckList_proof_of_ownership" style="color:green; font-size:30px; display:none;" class="fa fa-check"> </i>
              </div>
              <div class="col-4">

                  <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style=" height: 128px;">
                          @if (Auth::User()->ktp != null || Auth::User()->ktp != "")
                          <img src="{{Auth::User()->avatar}}" alt="image" /> @else
                          <img src="/gambar/ownership.png" alt="image" /> @endif
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                          <button type="button" class="btn btn-custom btn-file">
                           <span class="fileupload-new"><i class="fa fa-paperclip"></i> Pilih File</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                           {{-- poto profil is here : --}}
                           <input accept="image/*" type="file" class="btn-light" name="bukti_kepemilikan" id="bukti_kepemilikan">
                         </button>

                         <button id="btn_proof_of_ownership" class="btn btn-success"><span class="fileupload-new"><i class="fa fa-upload"></i> Unggah</span></button>
                      </div>
                  </div>

              </div>

              <div class="col-2">
                <label>Foto Nomor Seri Pesawat Tanpa Awak</label>
                <i id="CheckList_pic_of_drones_with_sn" style="color:green; font-size:30px; display:none;" class="fa fa-check"> </i>
              </div>

              <div class="col-4">
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style=" height: 128px;">
                          @if (Auth::User()->ktp != null || Auth::User()->ktp != "")
                          <img src="{{Auth::User()->avatar}}" alt="image" /> @else
                          <img src="/gambar/dronesn.jpeg" alt="image" /> @endif
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                          <button type="button" class="btn btn-custom btn-file">
                           <span class="fileupload-new"><i class="fa fa-paperclip"></i> Pilih File</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                           {{-- poto profil is here : --}}
                           <input accept="image/*" type="file" class="btn-light" name="nomorseripesawat" id="nomorseripesawat">
                         </button>
                         <button id="btn_pic_of_drones_with_sn" class="btn btn-success"><span class="fileupload-new"><i class="fa fa-upload"></i> Unggah</span></button>
                      </div>
                  </div>

              </div>
          </div>

          <div class="form-group row">
              <div class="col-2">
                <label>Foto Pesawat Tanpa Awak</label>
                <i id="CheckList_pic_of_drones" style="color:green; font-size:30px; display:none;" class="fa fa-check"> </i>
              </div>

              <div class="col-4">
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style=" height: 128px;">
                          @if (Auth::User()->ktp != null || Auth::User()->ktp != "")
                          <img src="{{Auth::User()->avatar}}" alt="image" /> @else
                          <img src="/gambar/drone.png" alt="image" /> @endif
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                          <button type="button" class="btn btn-custom btn-file">
                           <span class="fileupload-new"><i class="fa fa-paperclip"></i> Pilih File</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                           {{-- poto profil is here : --}}
                           <input accept="image/*" type="file" class="btn-light" name="fotopesawat" id="fotopesawat">
                         </button>
                         <button id="btn_pic_of_drones" class="btn btn-success"><span class="fileupload-new"><i class="fa fa-upload"></i> Unggah</span></button>
                      </div>
                  </div>

              </div>

              <div class="col-2">
                <label>Copy Bukti Penguasaan Pesawat Udara Tanpa Awak</label>
                <i id="CheckList_scan_proof_of_ownership" style="color:green; font-size:30px; display:none;" class="fa fa-check"> </i>
              </div>

              <div class="col-4">
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style=" height: 128px;">
                          @if (Auth::User()->ktp != null || Auth::User()->ktp != "")
                          <img src="{{Auth::User()->avatar}}" alt="image" /> @else
                          <img src="/gambar/ownership.png" alt="image" /> @endif
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                          <button type="button" class="btn btn-custom btn-file">
                           <span class="fileupload-new"><i class="fa fa-paperclip"></i> Pilih File</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                           {{-- poto profil is here : --}}
                           <input accept="image/*" type="file" class="btn-light" name="buktipenguasaan" id="buktipenguasaan">
                         </button>
                         <button id="btn_scan_proof_of_ownership" class="btn btn-success"><span class="fileupload-new"><i class="fa fa-upload"></i> Unggah</span></button>
                      </div>
                  </div>
              </div>
          </div>

        </fieldset>

        <h3>Pesawat Udara Tanpa Awak (Unmanned Aircraft System)</h3>
        <fieldset>
        <div class="row">
            <div class="col-md-6 form-group">
              <label for="name">Nama Pembuat (Manufacturer) <span class="text-danger">*</span></label>
              <input name="manufacturer" parsley-trigger="change" data-parsley-group="block1" type="text"  class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="company">Model<span class="text-danger">*</span></label>
              <select required id="model" class="form-control provinsi" name="model" data-placeholder="Silahkan Pilih...">
                <option value="">Silahkan Pilih...</option>
                <option value="Pesawat Terbang (Aeroplane)">Pesawat Terbang (Aeroplane)</option>
                <option value="Helikopter (Rotorcraft)">Helikopter (Rotorcraft)</option>
                <option value="Ornithopter (Ornithopter)">Ornithopter (Ornithopter)</option>
                <option value="Balon Udara (Balloon)">Balon Udara (Balloon)</option>
                <option value="Airship (Airship)">Pesawat Terbang (Aeroplane)</option>
                <option value="Glider (Glider)">Glider (Glider)</option>
                <option value="Kite (Glider)">Kite (Glider)</option>
                <option value="Lain-Lain (Other)">Lain-Lain (Other)</option>
              </select>
             </div>
            <div class="col-md-6 form-group">
              <label for="phone">Nama Model Khusus (Specific Model Name)<span class="text-danger">*</span></label>
              <input name="modelspesific" type="text" parsley-trigger="change" data-parsley-group="block1" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="phone">Tahun Pembuatan (Years Of Manufacture)<span class="text-danger">*</span></label>
              <input name="yearmake" type="text" parsley-trigger="change" data-parsley-group="block1" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="phone">Nomor Seri (Serial Number)<span class="text-danger">*</span></label>
              <input name="nomorseri" type="text" parsley-trigger="change" data-parsley-group="block1" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="phone">Keadaan (Condition)<span class="text-danger">*</span></label>
              <input name="condition" type="text" parsley-trigger="change" data-parsley-group="block1" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
              <label for="phone">Berat Maksimum Tinggal Landas (Maximum Take-Off Weight)<span class="text-danger">*</span></label>
              <input name="weighttakeoff" type="text" parsley-trigger="change" data-parsley-group="block1" class="form-control" required>
            </div>
        </div>
        <p>(*) Mandatory</p>
        </fieldset>

        <h3>Kepemilikan Pesawat Udara Tanpa Awak (UAS Ownership)</h3>
        <fieldset>
          <div class="row">
            <div class="col-md-6 form-group">
                <label for="termofowenership">Dasar Kepemilikan (Term of Ownership)<span class="text-danger">*</span></label>
                <select required id="model" class="form-control provinsi" name="termofowenership" data-placeholder="Silahkan Pilih...">
                  <option value="">Silahkan Pilih...</option>
                  <option value="Beli Tunai (Cash Purchase)">Beli Tunai (Cash Purchase)</option>
                  <option value="Pemberian (Gift)">Pemberian (Gift/Grant)</option>
                  <option value="Lain-lain">Lain-lain (Others)</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="name">Nama Pemilik (Owner) </label>
                <input name="owner" type="text" parsley-trigger="change" data-parsley-group="block2" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label for="phone">Alamat (Address) </label>
                <input name="address" type="text" parsley-trigger="change" data-parsley-group="block2" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label for="phone">Bukti Kepemilikan (Evidence of ownership)</label>
                <input name="evidenceofowenership" type="text" parsley-trigger="change" data-parsley-group="block2" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label for="phone">Tanggal Kepemilikan (Date)</label>
                <input name="dateownership" type="date" parsley-trigger="change" data-parsley-group="block2" class="form-control">
            </div>
          </div>

          <p>(*) Mandatory</p>
        </fieldset>

        <h3>Dasar Penguasaan Pesawat Udara Tanpa Awak (UAS Term Of Possession)</h3>
        <fieldset>
          <div class="row">
            <div class="col-md-6 form-group">
                <label for="termofowenership">Dasar Penguasaan (Term Of Possession) <span class="text-danger">*</span></label>
                <select required id="termofposession" class="form-control provinsi" name="termofposession" data-placeholder="Silahkan Pilih...">
                  <option value="">Silahkan Pilih...</option>
                  <option value="Sewa Guna Usaha (Leasing)">Sewa Guna Usaha (Leasing)</option>
                  <option value="Pembelian Bersyarat">Pembelian Bersyarat (Conditional Sale)</option>
                  <option value="Lain-lain">Lain-lain (Others)</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="name">Referensi</label>
                <input name="reference" type="text" parsley-trigger="change" data-parsley-group="block3" class="form-control">
            </div>

              <div class="col-md-12">
                <h4>Pemberi Sewa (Lessor)</h4>
              </div>

                <div class="col-md-6 form-group">
                    <label for="phone">Nama</label>
                    <input name="namapemberisewa" type="text" parsley-trigger="change" data-parsley-group="block3" class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="phone">Alamat</label>
                    <input name="alamatpemberisewa" type="text" parsley-trigger="change" data-parsley-group="block3" class="form-control">
                </div>

                <div class="col-md-6 form-group">
                    <label for="phone">Email</label>
                    <input name="emailpemberisewa" type="text" parsley-trigger="change" data-parsley-group="block3" class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input name="nomorteleponpemberisewa" type="text" parsley-trigger="change" data-parsley-group="block3" class="form-control">
                </div>

            </div>
          <p>(*) Mandatory</p>
        </fieldset>

        <h3>Pernyataan (Aggreements)</h3>
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
    @elseif ($status == 2)
      <div class="row">
        <div class="col-md-12">
          <div class="card-box">
              <center> <h1 class="display-4">Silahkan Mendaftarkan Identitas Diri Telebih Dahulu!</h1> </center>
          </div>
        </div>
      </div>
    @else
      <div class="row">
        <div class="col-md-12">
          <div class="card-box">
            <center> <h1 class="display-4">Anda Telah Mendaftarkan Drones</h1> </center>

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

      $("#btn_proof_of_ownership").click(function(e){
        $('#CheckList_proof_of_ownership').hide()
        var uploadedFile = new FormData();
        uploadedFile.append('bukti_kepemilikan', bukti_kepemilikan.files[0]);
        uploadedFile.append('_token', $('input[name=_token]').val());
        // uploadedFile.append('nameofFile', $('proof_of_ownership').val());
        $.ajax({
            type: "POST",
            url: '{{url(action('applicantController@uploadDokumenUAS'))}}',
            dataType: "json",
            processData: false, // important
            contentType: false, // important
            data: uploadedFile,
            success: function (data, status) {
              $('#CheckList_proof_of_ownership').show()
            },
            error: function (error) {
                alert('Kesalahan Saat Upload')
                console.log(error);
            }
        });
      });

  });

  $(document).ready(function() {
      $('.provinsi').select2();

      $("#btn_pic_of_drones_with_sn").click(function(e){
        $('#CheckList_pic_of_drones_with_sn').hide()
        var uploadedFile = new FormData();
        uploadedFile.append('nomorseripesawat', nomorseripesawat.files[0]);
        uploadedFile.append('_token', $('input[name=_token]').val());
        // uploadedFile.append('nameofFile', $('proof_of_ownership').val());
        $.ajax({
            type: "POST",
            url: '{{url(action('applicantController@uploadPesawatSn'))}}',
            dataType: "json",
            processData: false, // important
            contentType: false, // important
            data: uploadedFile,
            success: function (data, status) {
              $('#CheckList_pic_of_drones_with_sn').show()
            },
            error: function (error) {
                alert('Kesalahan Saat Upload')
                console.log(error);
            }
        });
      });

  });

  $(document).ready(function() {
      $('.provinsi').select2();

      $("#btn_pic_of_drones").click(function(e){
        $('#CheckList_pic_of_drones').hide()
        var uploadedFile = new FormData();
        uploadedFile.append('fotopesawat', fotopesawat.files[0]);
        uploadedFile.append('_token', $('input[name=_token]').val());
        // uploadedFile.append('nameofFile', $('proof_of_ownership').val());
        $.ajax({
            type: "POST",
            url: '{{url(action('applicantController@uploadPesawat'))}}',
            dataType: "json",
            processData: false, // important
            contentType: false, // important
            data: uploadedFile,
            success: function (data, status) {
              $('#CheckList_pic_of_drones').show()
            },
            error: function (error) {
                alert('Kesalahan Saat Upload')
                console.log(error);
            }
        });
      });

  });

  $(document).ready(function() {
      $('.provinsi').select2();

      $("#btn_scan_proof_of_ownership").click(function(e){
        $('#CheckList_scan_proof_of_ownership').hide()
        var uploadedFile = new FormData();
        uploadedFile.append('buktipenguasaan', buktipenguasaan.files[0]);
        uploadedFile.append('_token', $('input[name=_token]').val());
        // uploadedFile.append('nameofFile', $('proof_of_ownership').val());
        $.ajax({
            type: "POST",
            url: '{{url(action('applicantController@uploadPenguasaan'))}}',
            dataType: "json",
            processData: false, // important
            contentType: false, // important
            data: uploadedFile,
            success: function (data, status) {
              $('#CheckList_scan_proof_of_ownership').show()
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
          // if (newIndex === 1 && ! $('form').parsley().validate({group: 'block1', force: true}) )
          // {
          //     return false;
          // }
          // if (newIndex === 2 && ! $('form').parsley().validate({group: 'block2', force: true}) )
          // {
          //     return false;
          // }
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
@endsection
