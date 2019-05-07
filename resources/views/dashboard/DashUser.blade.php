@extends('layouts.dlayout')
@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | Pendaftaran @endsection

@section('content')
  <div id="example-basic">
      <h3>Data Diri</h3>
      <section>
          <div class="form-group clearfix">
            <label class="control-label" for="userName">Nama *</label>
            <div class="">
              <input class="form-control required" id="nama" name="nama" type="text" value="{{Auth::User()->nama}}">
            </div>
          </div>


      </section>
      <h3>Effects</h3>
      <section>
          <p>Wonderful transition effects.</p>
      </section>
      <h3>Pager</h3>
      <section>
          <p>The next and previous buttons help you to navigate through your content.</p>
      </section>
  </div>
@endsection


@section('jstambahan')
  <script type="text/javascript">
  $("#example-basic").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true
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
