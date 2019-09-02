@extends('layouts.dlayout')
@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | Pendaftaran @endsection

@section('content')
  <div class="row">

    <div class="col-12">
      <div class="card-box">
        <h4 class="header-title mb-4">Status Pendaftaran</h4>
        <div id="smartwizard">
              <ul>
                  <li>
                    <a href="#step-1">Registrasi DKKPU<br />
                      <small>Pengisian identitas dan detail drone</small>
                    </a>
                  </li>
                  <li>
                    <a href="#step-2">Nomor Drone dan Sertifikat Pilot<br />
                      <small>Penerbitan nomor setelah lulus assesment</small>
                    </a>
                  </li>
                  <li>
                    <a href="#step-3">Registrasi Airnav<br />
                      <small>Untuk penerbitan surat rekomendasi</small>
                    </a>
                  </li>
                  <li>
                    <a href="#step-4">Registrasi DNP<br />
                      <small>notam dan izin penerbangan drone.</small>
                    </a>
                  </li>
              </ul>

              <div>
                  <div id="step-1" class="">
                      Registrasi Yang Dilakukan Pada Website DKPPU, Meliputi Pengisian Identitas Diri, Data-Data Drone, dan Pertanyaan Kelayakan Pilot.
                  </div>
                  <div id="step-2" class="">
                      Anda Telah Berhasil Mendaftarkan Remote Pilot, dan memiliki drone yang bisa anda gunakan, silahkan lanjutkan pendaftaran pada airnav.
                  </div>
                  <div id="step-3" class="">
                      Silahkan Menuju Airnav, Untuk melanjutkan pendaftaran, data kami terhubung sehingga anda dapat melanjutkan pendaftaran dengan data yang ada telah masukkan di situs ini.
                  </div>
                  <div id="step-4" class="">
                      Step Content
                  </div>
              </div>
          </div>
      </div>
    </div>

    @if (Auth::User()->company != 4)
      <div class="col-6">
        <div class="card-box">
          <h4 class="header-title mb-4">Status Keanggotaan Perusahaan</h4>
          @if (Auth::User()->approved_company == 1)
            <p style="font-size:15px;">Terverifikasi <i style="color:green; font-size:15px;" class="fa fa-check"> </i> </p>
          @else
            <div class="">
               <p style="font-size:15px;">Pending Approval Perusahaan <i style="color:blue; font-size:15px;" class="fa fa-hourglass-2"> </i> </p>
            </div>

          @endif
        </div>
      </div>
    @endif


    <div class="col-6">
      <div class="card-box">
        <h4 class="header-title mb-4">Status UAS Assesment</h4>
        <?php
        $uas_regs = null;
        if (DB::table('uas_regs')->where('user_id',Auth::User()->id)->where('softdelete',0)->count() > 0) {
          $uas_regs = DB::table('uas_regs')->where('user_id',Auth::User()->id)->where('softdelete',0)->first()->status;
        }
        ?>
        @if ($uas_regs)
          @if ($uas_regs == 2)
            <p style="font-size:15px;">Sedang Di Nilai <i style="color:blue; font-size:15px;" class="fa fa-hourglass-2"> </i> </p>
          @elseif ($uas_regs == 1)
            <p style="font-size:15px;">Sedang Dikerjakan <i style="color:green; font-size:15px;" class="fa fa-hourglass-2"> </i> </p>
          @elseif ($uas_regs == 3)
            <p style="font-size:15px;">Lulus <i style="color:green; font-size:15px;" class="fa fa-check"> </i> </p>
          @elseif ($uas_regs == 4)
            <p style="font-size:15px;">Tidak Lulus <i style="color:red; font-size:15px;" class="fa fa-times"> </i> </p>
          @endif
        @else
          <div class="">
             <p style="font-size:15px;">Belum Ujian <i style="color:blue; font-size:15px;" class="fa fa-hourglass-1"> </i> </p>
          </div>
        @endif
      </div>
    </div>

    <div class="col-6">
      <div class="card-box">
        <h4 class="header-title mb-4">Status Remote Pilot</h4>
        @if (Auth::User()->ktp)
          @if (Auth::User()->approved == 1)
            <p style="font-size:15px;">Terverifikasi <i style="color:green; font-size:15px;" class="fa fa-check"> </i> </p>
          @elseif (Auth::User()->approved == '')
            <p style="font-size:15px;">Sedang Di Nilai <i style="color:blue; font-size:15px;" class="fa fa-hourglass-2"> </i> </p>
          @else
            <p style="font-size:15px;">Verifikasi Tidak Berhasil <i style="color:red; font-size:15px;" class="fa fa-times"> </i> </p>
          @endif
        @else
          <div class="">
             <p style="font-size:15px;">Belum Mendaftarkan Identitas <i style="color:blue; font-size:15px;" class="fa fa-hourglass-1"> </i> </p>
          </div>
        @endif
      </div>
    </div>
  </div>

@endsection


@section('jstambahan')
  <?php
  $status = 0;
  if (DB::table('remote_pilot')->where('user_id',Auth::User()->id)->where('status',1)->count() > 0) {
    if (DB::table('registered_drone')->where('user_id',Auth::User()->id)->where('status',1)->count() > 0) {
      $status = 2;
    }

    if (Auth::User()->approved_company == 1) {
      if (DB::table('registered_drone')->where('company',Auth::User()->company)->where('status',1)->count() > 0) {
        $status = 2;
      }
    }

  }
   ?>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#smartwizard').smartWizard({
          selected: {{$status}},
          theme: 'dots',
          toolbarSettings: {
            showNextButton: false
          }
        });
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

@endsection
