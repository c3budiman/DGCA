@extends('layouts.dlayout')

@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | Pendaftaran @endsection

@section('content')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
  <div class="content">
      <div class="container-fluid">

          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0">Mengelola Perusahaan</h4>
                    <p class="text-muted m-b-30">
                      Pada Menu ini, anda dapat menyetujui seseorang yang ingin bergabung ke perusahaan tertentu.
                    </p>

                    <p>Silahkan tentukan perusahaan yang ingin anda kelola :</p>
                    <select onchange="doSomething()" id="perusahaan" class="perusahaan" name="perusahaan" required>
                        <?php $table = DB::table('perusahaan')->where('approved',1)->get(); ?>
                          <option value="">Semua Perusahaan</option>
                        @foreach ($table as $row)
                          <option value="{{$row->id}}">{{$row->nama_perusahaan}}</option>
                        @endforeach
                    </select>
                  </div>
              </div>

              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h3>Rekrutmen Perusahaan : <span id="nama_perusahaannya"></span> </h3>
                      <table id="contoh" class="table table-bordered table-hover datatable2">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Nama</th>
                                  <th>Email</th>
                                  <th>Ingin Bergabung Ke</th>
                                  <th colspan="10%">Action</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            {{ csrf_field() }}
          </form>
          <div class="deleteContent">
            Are you sure to approve user : <span class="dname2"></span> ?
              <input type="hidden" id="iddelete">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn actionBtn" data-dismiss="modal" onclick="HideAgain()">
              <span id="footer_action_button" class='glyphicon'> </span>
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="HideAgain()">
              <span class='glyphicon glyphicon-remove'></span> Cancel
            </button>
          </div>

        </div>
        </div>
        </div>
        </div>
@endsection

@section('js')

  <!-- Bootstrap fileupload js -->
  <script src="{{url('/')}}/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script src="{{url('/')}}/plugins/select2/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
  <script src="{{url('/')}}/plugins/parsleyjs/parsley.min.js"></script>
  <!-- Sweet Alert Js  -->
  <script src="{{url('/')}}/plugins/sweet-alert/sweetalert2.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
        $('#perusahaan').select2();
    });

    table = $('.datatable2').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('manage/company/json') }}',
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'nama', name: 'users.nama'},
            {data: 'email', name: 'users.email'},
            {data: 'nama_perusahaan', name: 'perusahaan.nama_perusahaan'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    nama_perusahaannya.innerText = "Semua Perusahaan";

    function doSomething() {
      table.destroy();
      var e = document.getElementById("perusahaan");
      console.log(e.options[e.selectedIndex].value);
      var value = e.options[e.selectedIndex].value;
      var text = e.options[e.selectedIndex].text;
      nama_perusahaannya.innerText = text;
      table = $('.datatable2').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ url('/') }}/manage/company/json/"+value,
          columns: [
              {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
              {data: 'nama', name: 'users.nama'},
              {data: 'email', name: 'users.email'},
              {data: 'nama_perusahaan', name: 'perusahaan.nama_perusahaan'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    }

    $(document).on('click', '.delete-modal', function() {
          $('#footer_action_button').text("Approve");
          $('#footer_action_button').removeClass('glyphicon-check');
          $('#footer_action_button').addClass('glyphicon-trash');
          $('.actionBtn').removeClass('btn-success');
          $('.actionBtn').addClass('btn-success');
          $('.actionBtn').addClass('delete');
          $('.modal-title').text('Approve User To Company');
          $('.did').text($(this).data('id'));
          $('.deleteContent').show();
          $('.form-horizontal').hide();
          $('#iddelete').val($(this).data('id'));
          $('.dname').html($(this).data('name'));
          $('.dname2').html($(this).data('name2'));
          $('#myModal').modal('show');
      });
        $('.modal-footer').on('click', '.delete', function() {
            $.ajax({
                type: "POST",
                <?php
                $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
                 ?>
                url: "{{$link}}/manage/company/approve",
                dataType: "json",
                data: {
                  '_token': $('input[name=_token]').val(),
                  id: $("#iddelete").val(),
                },
                success: function (data, status) {
                    $('.datatable2').DataTable().ajax.reload(null, false);
                },
                error: function (request, status, error) {
                    console.log($("#iddelete").val());
                    console.log(request.responseJSON);
                    $.each(request.responseJSON.errors, function( index, value ) {
                      alert( value );
                    });
                }
            });
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
