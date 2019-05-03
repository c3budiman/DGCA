<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
?>
@extends('layouts.dlayout')

@section('title')
  Mengatur Email
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
                      <h4 class="m-t-0 header-title">Mengatur Email</h4>
                      <p class="text-muted font-14 m-b-30">
                          Anda bisa menambah, mengedit dan menghapus known email dimenu ini.
                      </p>
                      <div class="pull-right" style="margin-top:-50px">
                          <button type="button"  href="#" class="btn btn-xs btn-success" id="tambah"> <i class="fa fa-plus"></i> Tambah</button>
                      </div>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>id</th>
                                  <th>nama</th>
                                  <th>email</th>
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
            <div class="form-group">
              <label class="control-label col-sm-2" for="id">ID:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="fid" disabled>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="name">Nama:</label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="n">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="name">Email:</label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="eml">
              </div>
            </div>

          </form>

          <div class="deleteContent">
            Apakah anda yakin akan mendelete email : <span class="dname"></span> ?
              <input type="hidden" id="iddelete">
          </div>


          <div class="modal-footer">
            <button type="button" class="btn actionBtn" data-dismiss="modal">
              <span id="footer_action_button" class='glyphicon'> </span>
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span> Batal
            </button>
          </div>


        </div>
      </div>
    </div>
  </div>

  <!-- Signup modal content -->
  <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">

              <div class="modal-body">
                  <h2 class="text-uppercase text-center m-b-30">
                      <a href="index.html" class="text-success">
                          <span><img src="{{ asset($logo)}}" alt="" height="40"></span>
                      </a>
                  </h2>

                    <div class="form-group m-b-25">
                        <div class="col-12">
                            <label for="emailaddress">Alamat Email : </label>
                            <input class="form-control" type="email" id="emaildaftar" required="" placeholder="email@domain.com" name="email">
                        </div>
                    </div>

                      <div class="form-group m-b-25">
                          <div class="col-12">
                              <label for="username">Nama</label>
                              <input class="form-control" type="text" id="namadaftar" placeholder="nama">
                          </div>
                      </div>

                      <div class="form-group account-btn text-center m-t-10">
                          <div class="col-12">
                              <button id="submit" class="btn w-lg btn-rounded btn-primary waves-effect waves-light" type="submit">Daftarkan</button>
                          </div>
                      </div>

              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- Signup modal content -->



@endsection
@section('js')
  <script type="text/javascript">
  $(document).ready(function() {

    // DataTable
    $('.datatable').DataTable({
            "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian-Alternative.json"
        },
        processing: true,
        serverSide: true,
        ajax: '{{ route('known-email/json') }}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'nama', name: 'nama'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // ShowModals
    $(document).on('click', '.edit-modal', function() {
          $('#footer_action_button').text("Ubah");
          $('#footer_action_button').addClass('glyphicon-check');
          $('#footer_action_button').removeClass('glyphicon-trash');
          $('.actionBtn').addClass('btn-success');
          $('.actionBtn').removeClass('btn-danger');
          $('.actionBtn').addClass('edit');
          $('.modal-title').text('Ubah user');
          $('.deleteContent').hide();
          $('.form-horizontal').show();
          $('#fid').val($(this).data('id'));
          $('#n').val($(this).data('nama'));
          $('#eml').val($(this).data('email'));
          $('#avatar').val($(this).data('avatar'));
          $('#myModal').modal('show');
      });
      $(document).on('click', '.delete-modal', function() {
          $('#footer_action_button').text(" Delete");
          $('#footer_action_button').removeClass('glyphicon-check');
          $('#footer_action_button').addClass('glyphicon-trash');
          $('.actionBtn').removeClass('btn-success');
          $('.actionBtn').addClass('btn-danger');
          $('.actionBtn').addClass('delete');
          $('.modal-title').text('Delete');
          $('.did').text($(this).data('id'));
          $('.deleteContent').show();
          $('.form-horizontal').hide();
          $('#iddelete').val($(this).data('id'));
          $('.dname').html($(this).data('email'));
          $('#myModal').modal('show');
      });
      $(document).on('click', '#tambah', function() {
          $('#signup-modal').modal('show');
      });

      $('.modal-footer').on('click', '.edit', function() {
          $.ajax({
              type: "POST",
              url: "/e-surat/known-email/doedit",
              dataType: "json",
              data: {
                '_token': $('input[name=_token]').val(),
                id: $("#fid").val(),
                email: $("#eml").val(),
                nama: $("#n").val(),
              },
              success: function (data, status) {
                  $('.datatable').DataTable().ajax.reload(null, false);
              },
              error: function (request, status, error) {
                  console.log(request.responseJSON);
                  $.each(request.responseJSON.errors, function( index, value ) {
                    alert( value );
                  });
              }
          });
      });

      $('.modal-footer').on('click', '.delete', function() {
          $.ajax({
              type: "POST",
              url: "/e-surat/known-email/delete",
              dataType: "json",
              data: {
                '_token': $('input[name=_token]').val(),
                id: $("#iddelete").val(),
              },
              success: function (data, status) {
                  $('.datatable').DataTable().ajax.reload(null, false);
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

      $("#submit").click(function(){
        $.ajax({
            type: "POST",
            url: "/e-surat/known-email/add",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              email: $("#emaildaftar").val(),
              nama: $("#namadaftar").val(),
            },
            success: function (data, status) {
                $('#signup-modal').modal('hide');
                $("#emaildaftar").val(''),
                $("#namadaftar").val(''),
                $("#passworddaftar").val(''),
                $('.datatable').DataTable().ajax.reload(null, false);
            },
            error: function (request, status, error) {
                console.log(request.responseJSON);
                $.each(request.responseJSON.errors, function( index, value ) {
                  alert( value );
                });
            }
        });
      });
  });
  </script>

@endsection
