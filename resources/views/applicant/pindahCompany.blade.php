@extends('layouts.dlayout')

@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | UAS Assesment @endsection

@section('content')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

  <div class="row">
    <div class="col-lg-12">
      <div class="card card-body">
        <h2 style="vertical-align: middle; text-align: center;" >Pindah Perusahaan?</h2>
        <p style="vertical-align: middle; text-align: center;">
          Saat ini anda tercatat berada pada perusahaan : <b>{{DB::table('perusahaan')->where('id',Auth::User()->company)->first()->nama_perusahaan}}</b>
          <br>
          dengan Status :
          @if (Auth::User()->approved_company == 1)
            <b>Terverifikasi</b>
          @else
            <b>Belum Terverifikasi</b>
          @endif
        </p>
        <br>
        <form action="{{url(action('applicantController@doPindahPerusahaan'))}}" method="post">
          {{csrf_field()}}
          <blockquote style="text-align: center;" class="blockquote">
            <p>Silahkan tentukan perusahaan dimana anda ingin bergabung :</p>
            <select id="perusahaan" class="perusahaan" name="perusahaan" required>
                <?php $table = DB::table('perusahaan')->where('approved',1)->get(); ?>
                  <option value="">Silahkan Pilih...</option>
                @foreach ($table as $row)
                  <option value="{{$row->id}}">{{$row->nama_perusahaan}}</option>
                @endforeach
            </select>

          </blockquote>
          <br>
          <center>
            <button  type="submit" class="btn btn-info" name="submit">Simpan</button>
          </center>


        </form>

      </div>
    </div>
  </div>
@endsection

@section('js')
  <!-- Bootstrap fileupload js -->
  <script src="{{url('/')}}/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script src="{{url('/')}}/plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <script src="{{url('/')}}/plugins/parsleyjs/parsley.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

  <!-- Sweet Alert Js  -->
  <script src="{{url('/')}}/plugins/sweet-alert/sweetalert2.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
        $('#perusahaan').select2();
    });
  </script>

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
