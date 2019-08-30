@extends('layouts.dlayout')
@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | Pendaftaran @endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card-box">
        <h4 class="header-title mb-4">Status Pendaftaran Perusahaan</h4>
        <div id="smartwizard">
              <ul>
                  <li>
                    <a href="#step-1">Pendaftaran Pengelola<br />
                      <small>Pendaftaran akun pengelola perusahaan</small>
                    </a>
                  </li>
                  <li>
                    <a href="#step-2">Identitas Perusahaan<br />
                      <small>Pengisian detail perusahaan</small>
                    </a>
                  </li>
                  <li>
                    <a href="#step-3">Approval Admin<br />
                      <small>Admin Sedang Memverifikasi Pengajuan Perusahaan anda</small>
                    </a>
                  </li>
                  <li>
                    <a href="#step-4">Perusahaan Disetujui<br />
                      <small>Perusahaan telah disetujui admin dkppu.</small>
                    </a>
                  </li>
              </ul>

              <div>
                  <div id="step-1" class="">
                      Anda adalah pengelola perusahaan, anda dapat menambahkan pengguna lain untuk menjadi admin perusahaan, setelah pendaftaran perusahaan anda di setujui oleh admin DKPPU.
                  </div>
                  <div id="step-2" class="">
                      Isi Identitas Perusahaan dengan lengkap dan benar, agar dapat diajukan kepada admin.
                  </div>
                  <div id="step-3" class="">
                      Perusahaan sedang di periksa oleh admin dkppu.
                  </div>
                  <div id="step-4" class="">
                      Perusahaan telah disetujui, dan dapat mendaftarkan remote pilot serta drone dengan nama perusahaan.
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>

@endsection


@section('jstambahan')
  <?php
      $perusahaan    = DB::table('perusahaan')->where('id',Auth::User()->company)->first();
      $status = 1;
      if ($perusahaan->approved == 2) {
        $status = 2;
      } elseif ($perusahaan->approved == 1) {
        $status = 3;
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
