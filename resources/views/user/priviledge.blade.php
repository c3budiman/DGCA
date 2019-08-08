@extends('layouts.dlayout')

@section('title')
  Ubah Priviledge : "{{DB::table('users')->where('id','=',$id)->first()->nama}}"
@endsection

@section('content')
  <style media="screen">
    label {
      font-size: 18px !important;
      margin-top: 10px !important;
    }
  </style>
  <div class="row">
      <div class="col-12">
          <div class="card-box">
              <h3>Changing Priviledge for : "{{DB::table('users')->where('id','=',$id)->first()->nama}}"</h3>
              <p class="text-muted font-14 m-b-10">
                  In this menu you can change priviledge for managing the frontend`s menu
              </p>

              <form enctype="multipart/form-data" action="{{url(action('WebAdminController@RuleHakAkses'))}}" method="post" class="form-horizontal ">
                  {{ csrf_field() }}

                        @if ($priviledge)
                          <?php //dd($priviledge); ?>
                          <div class="form-group row">
                          @foreach ($priviledge as $prv => $hak_akses)
                            @foreach ($dashmenu as $mn)
                              <?php //dd($mn); ?>
                                 @if ($mn->method == $prv)
                                   <div class="col-4">
                                     <label for="">{{$mn->nama}}</label>
                                 @endif
                            @endforeach
                            <?php $arr_hak = array(); ?>
                            @foreach ($hak_akses as $hak)
                              <?php array_push($arr_hak, $hak->id_akses); ?>
                            @endforeach
                                  <div>
                                      <input type="checkbox" name="{{$prv.",1"}}" value="1"
                                      <?php //dd($arr_hak); ?>
                                      @if (in_array(1, $arr_hak, true))
                                        checked
                                      @endif >
                                      View
                                  </div>

                                <div>
                                    <input type="checkbox" name="{{$prv.",2"}}" value="2"
                                    @if (in_array(2, $arr_hak, true))
                                      checked
                                    @endif >
                                    Add
                                </div>

                                <div>
                                    <input type="checkbox" name="{{$prv.",3"}}" value="3"
                                    @if (in_array(3, $arr_hak, true))
                                      checked
                                    @endif >
                                    Edit
                                </div>

                                <div>
                                    <input type="checkbox" name="{{$prv.",4"}}" value="4"
                                    @if (in_array(4, $arr_hak, true))
                                      checked
                                    @endif >
                                    Delete
                                </div>
                              </div>
                          @endforeach
                          </div>
                        @endif

                        <input type="hidden" name="id" value="{{$id}}">

                  <div class="form-group row">
                      <div class="col-12">
                          <div class="pull-right">
                             {{-- onclick="alert('This menu still under Maintenance')" --}}
                              <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <!--  end row -->
@endsection

@section('jstambahan')
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
                        title: 'Success!',
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
