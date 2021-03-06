<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
?>
@extends('layouts.dlayout')

@section('title')
  Managing Front-End Menu
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
                      <h4 class="m-t-0 header-title">Front-End Menu Management</h4>
                      <p class="text-muted font-14 m-b-30">
                          You can add, edit and delete menu for frontend in here.
                      </p>
                      <div class="pull-right" style="margin-top:-50px">
                          <button type="button"  href="#" class="btn btn-xs btn-success" id="tambah"> <i class="fa fa-plus"></i> Add Menu</button>
                      </div>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Menu`s Name</th>
                                  <th>Method</th>
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
                            <label for="emailaddress">Menu`s Name : </label>
                            <input class="form-control" type="text" id="menu" required="" name="nama" placeholder="New Menu">
                        </div>
                    </div>

                      <div class="form-group m-b-25">
                          <div class="col-12">
                              <label for="username">Method : </label>
                              <input class="form-control" type="text" id="method" placeholder="newmenu">
                          </div>
                      </div>

                      <div class="form-group account-btn text-center m-t-10">
                          <div class="col-12">
                              <button id="submit" class="btn w-lg btn-rounded btn-primary waves-effect waves-light" type="submit">Add Menu</button>
                          </div>
                      </div>

              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
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
        ajax: '{{ route('front/json') }}',
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'nama', name: 'nama'},
            {data: 'method', name: 'method'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // ShowModals
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
          $('.dname').html($(this).data('name'));
          $('#myModal').modal('show');
      })
      ;
      $(document).on('click', '#tambah', function() {
          $('#signup-modal').modal('show');
      });

      $('.modal-footer').on('click', '.delete', function() {
          $.ajax({
              type: "POST",
              <?php
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
               ?>
              url: "/deleteFront",
              dataType: "json",
              data: {
                '_token': $('input[name=_token]').val(),
                id: $("#iddelete").val(),
              },
              success: function (data, status) {
                  $('.datatable').DataTable().ajax.reload(null, false);
                  swal({
                    title: "success!",
                    text: "Menu has been deleted",
                    icon: "success",
                    button: "okay",
                  });
              },
              error: function (request, status, error) {
                  console.log($("#iddelete").val());
                  console.log(request.responseJSON.error);
                  swal({
                    title: "Error!",
                    text: request.responseJSON.error,
                    type: "error",
                    confirmButtonClass: "btn btn-confirm mt-2",
                  });
                  $.each(request.responseJSON.errors, function( index, value ) {
                    alert( value );
                  });
              }
          });
      });

      $("#submit").click(function(){
        $.ajax({
            type: "POST",
            url: "/front",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              menu: $("#menu").val(),
              link: $("#link").val(),
              method: $("#method").val(),
            },
            success: function (data, status) {
                $('#signup-modal').modal('hide');
                $("#menu").val(''),
                $("#link").val(''),
                $("#method").val(''),
                $('.datatable').DataTable().ajax.reload(null, false);
                swal({
                  title: "success!",
                  text: "Menu has been created",
                  icon: "success",
                  button: "okay",
                });
            },
            error: function (request, status, error) {
                console.log(error.error);
                console.log(request.responseJSON.Error);
                console.log(status);
                $('#signup-modal').modal('hide');
                $("#menu").val('');
                $("#method").val('');
                swal({
                  title: "Error!",
                  text: request.responseJSON.Error,
                  type: "error",
                  confirmButtonClass: "btn btn-confirm mt-2",
                });
                $.each(request.responseJSON.errors, function( index, value ) {
                  alert( value );
                });
            }
        });
      });
  });
  </script>

@endsection
