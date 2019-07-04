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
                      Step Content
                  </div>
                  <div id="step-3" class="">
                      Step Content
                  </div>
                  <div id="step-4" class="">
                      Step Content
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>

@endsection


@section('jstambahan')
  <script type="text/javascript">
    $(document).ready(function(){
        $('#smartwizard').smartWizard({
          selected: 0,
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
