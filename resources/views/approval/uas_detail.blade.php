@extends('layouts.dlayout')

@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | Pendaftaran @endsection

@section('content')
  <style media="screen">
  #button-group {
      margin: auto;
      display: flex;
      flex-direction: row;
      justify-content: center;
    }
  </style>
  <!-- Toastr css -->
  <link href="{{url('/')}}/../plugins/jquery-toastr/jquery.toast.min.css" rel="stylesheet">

  <div class="row">
    <div class="col-lg-12">
      <div class="card card-body">
        <h5 class="card-title">Hasil Evaluasi UAS Assesment</h5>
        <p class="card-text">Berikut adalah hasil evaluasi assesment pengaju : <a href="/detail/identitas/{{$nama_orang->id}}">{{$nama_orang->nama}}</a> oleh {{$uas_reg->change_by}}.</p>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <?php $i=0; ?>
      @foreach ($soal as $soalnya)
        <?php $i++; ?>
        <div class="card m-b-30 card-body">
          <h5 class="card-title">Nomor {{$i}}</h5>
          <p class="card-text">{!!DB::table('soal')->where('id',$soalnya->id_soal)->first()->soal!!}</p>
          <h5 class="card-title">Jawaban :</h5>
          <div class="card-box">
            {!! $soalnya->jawaban !!}
          </div>

          <div class="card-footer">
            @if ($soalnya->satisfy == 1)
              <h5 class="card-title">Status Nilai : <span id="status_kepuasan_{{$soalnya->id}}" style="padding:10px" class="badge badge-info">Puas</span></h5>
            @elseif ($soalnya->satisfy == 2)
              <h5 class="card-title">Status Nilai : <span id="status_kepuasan_{{$soalnya->id}}" style="padding:10px" class="badge badge-danger">Tidak Puas</span></h5>
            @elseif ($soalnya->satisfy == 99)
              <h5 class="card-title">Status Nilai : <span id="status_kepuasan_{{$soalnya->id}}" style="padding:10px" class="badge badge-warning">Netral</span></h5>
            @else
              <h5 class="card-title">Status Nilai : <span id="status_kepuasan_{{$soalnya->id}}" style="padding:10px" class="badge badge-secondary">Pending</span></h5>
            @endif

            <hr>
            <h5 class="card-title">Keterangan :</h5>
            {{$soalnya->remarks}}

          </div>
        </div>

      @endforeach
    </div>
  </div>
@endsection

@section('js')
  <script src="{{url('/')}}/../plugins/jquery-toastr/jquery.toast.min.js"></script>
  <script type="text/javascript">
    function openketerangan(id) {
      document.getElementById('keterangan_'+id).style.display = 'block';
      document.getElementById('btn_ket_'+id).style.display = 'none';
      document.getElementById('btn_saveket_'+id).style.display = 'block';
      document.getElementById('btn_batal_'+id).style.display = 'block';
    }

    function batal_save(id) {
      document.getElementById('keterangan_'+id).style.display = 'none';
      document.getElementById('btn_ket_'+id).style.display = 'block';
      document.getElementById('btn_saveket_'+id).style.display = 'none';
      document.getElementById('btn_batal_'+id).style.display = 'none';
    }

    function saveketerangan(id) {
      $.ajax({
          type: "POST",
          url: "{{url('/')}}/approval/saveketerangan",
          dataType: "json",
          data: {
            '_token': $('input[name=_token]').val(),
            id      : id,
            uas_regs: {{$uas_regs}},
            keterangan : document.getElementById('keterangan_'+id).value,
          },
          success: function (data, status) {
              console.log(data)
              $.toast({
                  heading: "Sukses!",
                  text: "Keterangan Tersimpan.",
                  position: "top-right",
                  loaderBg: "#359f56",
                  icon: "success",
                  hideAfter: 3e3,
                  allowToastClose: false,
                  stack: 1
              })
              batal_save(id)
          },
          error: function (request, status, error) {
              console.log(request.responseJSON);
              $.each(request.responseJSON.errors, function( index, value ) {
                alert( value );
              });
          }
      });
    }

    function saveKepuasan(id,satisfy) {
      $.ajax({
          type: "POST",
          url: "{{url('/')}}/approval/saveKepuasan",
          dataType: "json",
          data: {
            '_token': $('input[name=_token]').val(),
            id      : id,
            uas_regs: {{$uas_regs}},
            satisfy : satisfy,
          },
          success: function (data, status) {
              if (satisfy == 1) {
                console.log(document.getElementById("status_kepuasan_"+id))
                document.getElementById("status_kepuasan_"+id).className = '';
                document.getElementById("status_kepuasan_"+id).className = 'badge badge-info';
                document.getElementById("status_kepuasan_"+id).innerHTML = 'Puas';
                $.toast({
                    heading: "Sukses!",
                    text: "Nilai Assesment Tersimpan.",
                    position: "top-right",
                    loaderBg: "#356c9f",
                    icon: "info",
                    hideAfter: 3e3,
                    allowToastClose: false,
                    stack: 1
                })

              } else if (satisfy == 2) {
                document.getElementById("status_kepuasan_"+id).className = '';
                document.getElementById("status_kepuasan_"+id).className = 'badge badge-danger';
                document.getElementById("status_kepuasan_"+id).innerHTML = 'Tidak Puas';
                $.toast({
                    heading: "Sukses!",
                    text: "Nilai Assesment Tersimpan.",
                    position: "top-right",
                    loaderBg: "#e22a2a",
                    icon: "error",
                    hideAfter: 3e3,
                    allowToastClose: false,
                    stack: 1
                })
              } else if (satisfy == 99) {
                document.getElementById("status_kepuasan_"+id).className = '';
                document.getElementById("status_kepuasan_"+id).className = 'badge badge-warning';
                document.getElementById("status_kepuasan_"+id).innerHTML = 'Netral';
                $.toast({
                    heading: "Sukses!",
                    text: "Nilai Assesment Tersimpan.",
                    position: "top-right",
                    loaderBg: "#dee243",
                    icon: "warning",
                    hideAfter: 3e3,
                    allowToastClose: false,
                    stack: 1
                })
              }
              console.log(data)
          },
          error: function (request, status, error) {
              console.log(request.responseJSON);
              $.each(request.responseJSON.errors, function( index, value ) {
                alert( value );
              });
          }
      });
    }

    function puas(id) {
      console.log('puas di id : ', id)
      saveKepuasan(id,1)
    }

    function tpuas(id) {
      console.log('tpuas di id : ', id)
      saveKepuasan(id,2)
    }

    function netral(id) {
      console.log('netral di id : ', id)
      saveKepuasan(id,99)
    }
  </script>
  <!-- Bootstrap fileupload js -->
  <script src="{{url('/')}}/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script src="{{url('/')}}/plugins/select2/js/select2.min.js"></script>
  <script src="{{url('/')}}/plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <script src="{{url('/')}}/plugins/parsleyjs/parsley.min.js"></script>

  <script src="{{url('/')}}/templateEditor/ckeditor/ckeditor.js"></script>
  <script>
    var options = {
      filebrowserImageBrowseUrl: '{{url('/')}}/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '{{url('/')}}/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '{{url('/')}}/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '{{url('/')}}//laravel-filemanager/upload?type=Files&_token='
    };
  </script>

  <!-- Sweet Alert Js  -->
  <script src="{{url('/')}}/plugins/sweet-alert/sweetalert2.min.js"></script>

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
          console.log("tes");
          $('form').parsley();
      });
  </script>
@endsection
