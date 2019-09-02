<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
?>
@extends('layouts.dlayout')

@section('title')
  Approval and Data Management
@endsection

@section('css')
  <script src="{{ asset('js/app2.js') }}"></script>
@endsection

@section('content')
  <!-- Start Page content -->
  <div class="content">
      <div class="container-fluid">

          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h4 class="m-t-0 header-title">Pending Approval</h4>
                      <p class="text-muted font-14 m-b-30">
                          Data UAS yang siap di periksa dan di approve.
                      </p>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Foto Drone</th>
                                  <th>Nama Pemilik</th>
                                  <th>Perusahaan</th>
                                  <th>Model</th>
                                  <th colspan="10%">Action</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="content">
      <div class="container-fluid">

          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h4 class="m-t-0 header-title">Registered Drone</h4>
                      <p class="text-muted font-14 m-b-30">
                          Data data yang telah di approve.
                      </p>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable2">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Nama Pemilik</th>
                                  <th>Model</th>
                                  <th>Nomor Lisensi Drones</th>
                                  <th>Status</th>
                                  <th>Validator</th>
                                  <th>Tanggal Approval</th>
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
            <input type="hidden" class="form-control" id="fid" disabled>

            <div class="form-group">
              <label class="control-label col-sm-2" for="name">Name:</label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="n" disabled>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-12" for="name">Nomor Drone:</label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="eml" disabled>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-12" for="name">Status Peninjauan :</label>
              <div class="col-sm-10">
                <select class="form-control" name="status_peninjauan">
                  <option value="1">Aktif</option>
                  <option value="2">Nonaktif</option>
                  <option value="3">Nonaktif Sementara</option>
                  <option value="4">Lisensi di Cabut</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-12" for="name">Alasan Peninjauan :</label>
              <div class="col-sm-10">
                <input type="alasan" class="form-control" id="alasan_pk">
              </div>
            </div>

          </form>

          <div class="deleteContent">
            Are you sure to delete user with id : <span class="dname"></span> <span
              class="hidden did"></span> ?
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
  <script src="{!! asset('plugins/bootstrap-fileupload/bootstrap-fileupload.js') !!}"></script>
  <!-- Sweet Alert Js  -->
  <script src="{!! asset('plugins/sweet-alert/sweetalert2.min.js') !!}"></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // ShowModals
    $(document).on('click', '.edit-modal', function() {
          $('#footer_action_button').text("Simpan");
          $('#footer_action_button').addClass('glyphicon-check');
          $('#footer_action_button').removeClass('glyphicon-trash');
          $('.actionBtn').addClass('btn-info');
          $('.actionBtn').removeClass('btn-danger');
          $('.actionBtn').addClass('edit');
          $('.modal-title').text('Peninjauan Kembali');
          $('.deleteContent').hide();
          $('.form-horizontal').show();
          $('#fid').val($(this).data('id'));
          $('#n').val($(this).data('nama'));
          $('#eml').val($(this).data('email'));
          $('#avatar').val($(this).data('avatar'));
          $('#myModal').modal('show');
      });

      $('.modal-footer').on('click', '.edit', function() {
          $.ajax({
              type: "POST",
              <?php
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
               ?>
              url: "{{url('/')}}/savePKDrone",
              dataType: "json",
              data: {
                '_token': $('input[name=_token]').val(),
                id: $("#fid").val(),
                nomor_drone: $("#eml").val(),
                status_peninjauan: $('select[name=status_peninjauan]').val(),
                alasan_pk: $("#alasan_pk").val(),
              },
              success: function (data, status) {
                  document.getElementById('alasan_pk').value = "";
                  $('.datatable2').DataTable().ajax.reload(null, false);
              },
              error: function (request, status, error) {
                  console.log(request.responseJSON);
                  $.each(request.responseJSON.errors, function( index, value ) {
                    alert( value );
                  });
              }
          });
      });

    //DataTable
    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('approvedrones/json') }}',
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'drones_image', name: 'drones_image', orderable: false, searchable: false},
            {data: 'nama', name: 'users.nama'},
            {data: 'nama_perusahaan', name: 'perusahaan.nama_perusahaan'},
            {data: 'model', name: 'drones.model'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('.datatable2').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('approvedrones2/json') }}',
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'nama', name: 'users.nama'},
            {data: 'model', name: 'model'},
            {data: 'nomor_drone', name: 'registered_drone.nomor_drone'},
            {data: 'status', name: 'registered_drone.status'},
            {data: 'validator', name: 'validator', orderable: false, searchable: false},
            {data: 'csr', name: 'registered_drone.created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

  });
  </script>

@endsection
