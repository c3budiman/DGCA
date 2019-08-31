<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
?>
@extends('layouts.dlayout')

@section('title')
  Approval Perusahaan
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
                      <h4 class="m-t-0 header-title">Ready To Approve</h4>
                      <p class="text-muted font-14 m-b-30">
                          Data yang siap untuk di cek dan di approve.
                      </p>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Nama Perusahaan</th>
                                  <th>Nomor Telepon</th>
                                  <th>Nomor Siup</th>
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
                      <h4 class="m-t-0 header-title">Approval History</h4>
                      <p class="text-muted font-14 m-b-30">
                          Data yang telah di approve
                      </p>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable2">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Nama Perusahaan</th>
                                  <th>Nomor Telepon</th>
                                  <th>Nomor Siup</th>
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
          <div class="deleteContent">
            Are you sure to delete ?
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

  <div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title2"></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal2" role="form">
            {{ csrf_field() }}
            <div class="form-group">
              <label class="control-label col-sm-2" for="id">Disposition:</label>

              <div class="col-sm-10">
                <input type="checkbox" name="disposition" value="read"> Read
                <input type="checkbox" name="disposition" value="insert"> Insert
                <input type="checkbox" name="disposition" value="update"> Update
                <input type="checkbox" name="disposition" value="delete"> Delete
              </div>

            </div>
          </form>

          {{-- <div class="deleteContent2">
            Apakah anda yakin akan mendelete User dengan id : <span class="dname"></span> <span
              class="hidden did"></span> ?
              <input type="hidden" id="iddelete">
          </div> --}}


          <div class="modal-footer">
            <button type="button" class="btn actionBtn2" data-dismiss="modal">
              <span id="footer_action_button2" class='glyphicon'> </span>
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span> Cancel
            </button>
          </div>


        </div>
      </div>
    </div>
  </div>

  <!-- Add Front menu content -->

  <!-- Signup modal content -->



@endsection
@section('js')
  <!-- Bootstrap fileupload js -->
  <script src="{!! asset('plugins/bootstrap-fileupload/bootstrap-fileupload.js') !!}"></script>
  <!-- Sweet Alert Js  -->
  <script src="{!! asset('plugins/sweet-alert/sweetalert2.min.js') !!}"></script>

  <script type="text/javascript">
  $(document).ready(function() {

    //DataTable
    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('approval/company/json') }}',
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'nama_perusahaan', name: 'nama_perusahaan'},
            {data: 'nomor_telepon', name: 'nomor_telepon'},
            {data: 'nomor_siup', name: 'nomor_siup'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('.datatable2').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('approved/company/json') }}',
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'nama_perusahaan', name: 'nama_perusahaan'},
            {data: 'nomor_telepon', name: 'nomor_telepon'},
            {data: 'nomor_siup', name: 'nomor_siup'},
            {data: 'nama', name: 'users.nama'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });


  });
  </script>

@endsection
