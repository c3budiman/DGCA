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
    if (DB::table('perusahaan')->where('id',Auth::User()->company)->count() > 0) {
      $perusahaan = DB::table('perusahaan')->where('id',Auth::User()->company)->first();
    } else {
      $perusahaan = DB::table('perusahaan')->where('id',1)->get();
    }
    $status = 'Perusahaan Sedang Di Verifikasi Admin';
    if ($perusahaan->approved == 1) {
      $status = 'Perusahaan Telah Terdaftar dan Disetujui';
    }
   ?>


  @if ($perusahaan->approved == 2 || $perusahaan->approved == 1)
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card-box table-responsive">
                        <h4 class="m-t-0 header-title">Rincian UAS</h4>
                        <br>
                        <form action="/approval/perusahaan/{{$perusahaan->id}}" role="form" method="post">
                        <input type="hidden" name="_method" value="put">
                        {{ csrf_field() }}
                        <table id="contoh" class="table table-bordered table-hover datatable">
                            <tbody>
                                <tr>
                                    <td bgcolor="#4cd06d" align="center" colspan="2">Status : {{$status}}</td>
                                </tr>
                                <tr>
                                  <td bgcolor="#c0d04c" align="center" colspan="2">Dokumen Perusahaan (Registration Documents)</td>
                                </tr>
                                <tr>
                                    <td>Scan SIUP</td>
                                    @if ($perusahaan->dokumen_siup)
                                      <td><a href="{{json_decode($perusahaan->dokumen_siup)->original}}"> <img height="100px" src="{{json_decode($perusahaan->dokumen_siup)->resized}}" alt=""> </a></td>
                                    @else
                                      <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Scan KTP Penanggung</td>
                                    @if ($perusahaan->dokumen_ktp_penanggung)
                                      <td><a href="{{json_decode($perusahaan->dokumen_ktp_penanggung)->original}}"> <img height="100px" src="{{json_decode($perusahaan->dokumen_ktp_penanggung)->resized}}" alt=""> </a></td>
                                    @else
                                      <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Scan NPWP</td>
                                    @if ($perusahaan->dokumen_npwp)
                                      <td><a href="{{json_decode($perusahaan->dokumen_npwp)->original}}"> <img height="100px" src="{{json_decode($perusahaan->dokumen_npwp)->resized}}" alt=""> </a></td>
                                    @else
                                      <td></td>
                                    @endif
                                </tr>
                                <tr>
                                  <td bgcolor="#c0d04c" align="center" colspan="2">Identitas Perusahaan</td>
                                </tr>
                                <tr>
                                    <td>Nama Perusahaan</td>
                                    <td>{{$perusahaan->nama_perusahaan}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat Perusahaan</td>
                                    <td>{{$perusahaan->alamat_perusahaan}}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Telepon</td>
                                    <td>{{$perusahaan->nomor_telepon}}</td>
                                </tr>
                                <tr>
                                    <td>Nomor SIUP</td>
                                    <td>{{ $perusahaan->nomor_siup}}</td>
                                </tr>

                                <tr>
                                    <td>Nomor NPWP</td>
                                    <td>{{ $perusahaan->nomor_npwp}}</td>
                                </tr>

                                <tr>
                                    <td>Nomor KTP Penanggung</td>
                                    <td>{{ $perusahaan->nomor_ktp_penanggung}}</td>
                                </tr>

                            </tbody>
                        </table>
                        <hr>
                    </form>
                    @if (Auth::User()->roles_id == 3)
                      <a href="/dashboard" class="btn btn-sm btn-secondary pull-right mr-2">Kembali</a>
                    @else
                      <a href="/dashboard" class="btn btn-sm btn-secondary pull-right mr-2">Kembali</a>
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
  @elseif ($perusahaan->approved == 1)
    Telah Terverifikasi
  @else
    <form enctype="application/x-www-form-urlencoded" data-parsley-validate id="example-advanced-form" action="{{url(action('AdminPerusahaanController@SaveIsianPerusahaan'))}}" method="post">
        {{ csrf_field() }}

        <h3>Dokumen</h3>
        <fieldset>

          <div class="form-group row">
                <div class="col-2">
                  <label>Scan KTP Penanggung Jawab</label>
                  <i id="dokumen_ktp_penanggung" style="color:green; font-size:30px; display:none;" class="fa fa-check"> </i>
                </div>
                <div class="col-4">

                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style=" height: 128px;">
                            @if ($perusahaan->dokumen_ktp_penanggung != null || $perusahaan->dokumen_ktp_penanggung != "")
                            <img src="{{json_decode($perusahaan->dokumen_ktp_penanggung)->resized}}" alt="image" /> @else
                            <img src="/gambar/ktp.jpg"alt="image" />  @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <button type="button" class="btn btn-custom btn-file">
                             <span class="fileupload-new"><i class="fa fa-paperclip"></i> Pilih File</span>
                             <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                             {{-- poto profil is here : --}}
                             <input accept="image/*" type="file" class="btn-light" name="dokumen_ktp_penanggunga" id="dokumen_ktp_penanggunga">
                           </button>

                           <button id="btn_dokumen_ktp_penanggung" class="btn btn-success"><span class="fileupload-new2"><i class="fa fa-upload"></i> Unggah</span></button>
                        </div>
                    </div>

                </div>

                <div class="col-2">
                  <label>Scan Surat Izin Usaha Perdagangan (SIUP)</label>
                  <i id="dokumen_siup" style="color:green; font-size:30px; display:none;" class="fa fa-check"> </i>
                </div>

                <div class="col-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style=" height: 128px;">
                            @if ($perusahaan->dokumen_siup != null || $perusahaan->dokumen_siup != "")
                            <img src="{{json_decode($perusahaan->dokumen_siup)->resized}}" alt="image" /> @else
                            <img src="/gambar/ownership.png"alt="image" /> @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <button type="button" class="btn btn-custom btn-file">
                             <span class="fileupload-new"><i class="fa fa-paperclip"></i> Pilih File</span>
                             <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                             {{-- poto profil is here : --}}
                             <input accept="image/*" type="file" class="btn-light" name="dokumen_siup" id="dokumen_siupa" >
                           </button>
                           <button id="btn_dokumen_siup" class="btn btn-success"><span class="fileupload-new2"><i class="fa fa-upload"></i> Unggah</span></button>
                        </div>
                    </div>

                </div>
          </div>

          <div class="form-group row">
                <div class="col-2">
                  <label>Scan Dokumen NPWP</label>
                  <i id="dokumen_npwp" style="color:green; font-size:30px; display:none;" class="fa fa-check"> </i>
                </div>
                <div class="col-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style=" height: 128px;">
                            @if ($perusahaan->dokumen_npwp != null || $perusahaan->dokumen_npwp != "")
                            <img src="{{json_decode($perusahaan->dokumen_npwp)->resized}}" alt="image" /> @else
                            <img src="/gambar/ownership.png"alt="image" />  @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <button type="button" class="btn btn-custom btn-file">
                             <span class="fileupload-new"><i class="fa fa-paperclip"></i> Pilih File</span>
                             <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                             {{-- poto profil is here : --}}
                             <input accept="image/*" type="file" class="btn-light" name="dokumen_npwp" id="dokumen_npwpa">
                           </button>

                           <button id="btn_dokumen_npwp" class="btn btn-success"><span class="fileupload-new2"><i class="fa fa-upload"></i> Unggah</span></button>
                        </div>
                    </div>
                </div>
          </div>

        </fieldset>
        <h3>Identitas Perusahaan</h3>
        <fieldset>
          <?php //dd(Auth::User()) ?>
            <div class="form-group">
              <label for="name">Nama Perusahaan (Company Name) <span class="text-danger">*</span></label>
              <input value="{{ $perusahaan->nama_perusahaan }}" parsley-trigger="change" data-parsley-group="block2" type="text" name="nama" class="form-control" id="name" required>
            </div>
            <div class="form-group">
              <label for="phone">No Telepon Perusahaan (Phone)<span class="text-danger">*</span></label>
              <input name="phone" type="text" value="{{$perusahaan->nomor_telepon}}" id="phone" parsley-trigger="change" data-parsley-group="block2" data-parsley-type="number" data-parsley-minlength="10" data-parsley-maxlength="13" placeholder="08xxxxxxxxxx" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="phone">Alamat Perusahaan<span class="text-danger">*</span></label>
              <textarea name="alamat" parsley-trigger="change" data-parsley-group="block2" required class="form-control" rows="8" cols="80">{{$perusahaan->alamat_perusahaan}}</textarea>
            </div>
        <p>(*) Mandatory</p>
        </fieldset>

        <h3>Nomor Berkas</h3>
        <fieldset>
          <?php //dd(Auth::User()) ?>
            <div class="form-group">
              <label for="name">Nomor SIUP <span class="text-danger">*</span></label>
              <input value="{{ $perusahaan->nomor_siup }}" parsley-trigger="change" data-parsley-group="block3" type="text" name="nomor_siup" class="form-control" id="nomor_siup" required>
            </div>
            <div class="form-group">
              <label for="phone">Nomor NPWP<span class="text-danger">*</span></label>
              <input value="{{ $perusahaan->nomor_npwp }}" parsley-trigger="change" data-parsley-group="block3" type="text" name="nomor_npwp" class="form-control" id="nomor_npwp" required>
            </div>
            <div class="form-group">
              <label for="phone">Nomor KTP Penanggung Jawab<span class="text-danger">*</span></label>
              <input value="{{ $perusahaan->nomor_ktp_penanggung }}" parsley-trigger="change" data-parsley-group="block3" type="text" name="nomor_ktp_penanggung" class="form-control" id="nomor_ktp_penanggung" required>
            </div>
        <p>(*) Mandatory</p>
        </fieldset>




        <h3>Selesai</h3>
        <fieldset>
            <legend>Terms and Conditions</legend>

            <input id="acceptTerms-2" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
        </fieldset>
    </form>
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

  $(document).ready(function() {
      $("#btn_dokumen_ktp_penanggung").click(function(e){
        $('#dokumen_ktp_penanggung').hide()
        var uploadedFile = new FormData();
        uploadedFile.append('dokumen_ktp_penanggung', dokumen_ktp_penanggunga.files[0]);
        uploadedFile.append('_token', $('input[name=_token]').val());
        $.ajax({
            type: "POST",
            url: '{{url(action('AdminPerusahaanController@UploadDokumenPerusahaan'))}}',
            dataType: "json",
            processData: false, // important
            contentType: false, // important
            data: uploadedFile,
            success: function (data, status) {
              $('#dokumen_ktp_penanggung').show()
            },
            error: function (error) {
                alert('Kesalahan Saat Upload')
                console.log(error);
            }
        });
      });

      $("#btn_dokumen_npwp").click(function(e){
        $('#dokumen_npwp').hide()
        var uploadedFile = new FormData();
        uploadedFile.append('dokumen_npwp', dokumen_npwpa.files[0]);
        uploadedFile.append('_token', $('input[name=_token]').val());
        $.ajax({
            type: "POST",
            url: '{{url(action('AdminPerusahaanController@UploadDokumenPerusahaan'))}}',
            dataType: "json",
            processData: false, // important
            contentType: false, // important
            data: uploadedFile,
            success: function (data, status) {
              $('#dokumen_npwp').show()
            },
            error: function (error) {
                alert('Kesalahan Saat Upload')
                console.log(error);
            }
        });
      });

      $("#btn_dokumen_siup").click(function(e){
        $('#dokumen_siup').hide()
        var uploadedFile = new FormData();
        uploadedFile.append('dokumen_siup', dokumen_siupa.files[0]);
        uploadedFile.append('_token', $('input[name=_token]').val());
        $.ajax({
            type: "POST",
            url: '{{url(action('AdminPerusahaanController@UploadDokumenPerusahaan'))}}',
            dataType: "json",
            processData: false, // important
            contentType: false, // important
            data: uploadedFile,
            success: function (data, status) {
              $('#dokumen_siup').show()
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
          //
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
