<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
?>
@extends('layouts.dlayout')

@section('title')
  Managing Users
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
                      <h4 class="m-t-0 header-title">User Management</h4>
                      <p class="text-muted font-14 m-b-30">
                          You can add, edit and delete users in this menu.
                      </p>
                      <div class="pull-right" style="margin-top:-50px">
                          <button type="button"  href="#" class="btn btn-xs btn-success" id="tambah"> <i class="fa fa-plus"></i> Add</button>
                      </div>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Avatar</th>
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
              <label class="control-label col-sm-2" for="name">Name:</label>
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

            <div class="form-group">
              <label class="control-label col-sm-2" for="name">Roles:</label>
              <div class="col-sm-10">
                <select id="roles" class="form-control" name="roles_id2">
                    <?php $rolestable = DB::table('roles')->get(); ?>
                    @foreach ($rolestable as $roles)
                    <option value="{{$roles->id}}">{{$roles->namaRule}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="name">Avatar: </label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="avatar">
              </div>
            </div>

            <button style="margin-left:15px" id="unhide" type="button" name="button" class="btn btn-danger" onclick="UnHide()">Reset User Password</button>
            <script type="text/javascript">
              function UnHide() {
                document.getElementById('password_hidden').style.visibility = "visible";
                document.getElementById('unhide').style.visibility = "hidden";
              }

              function HideAgain() {
                document.getElementById('password_hidden').style.visibility = "hidden";
                document.getElementById('unhide').style.visibility = "visible";
              }
            </script>
            <div class="password_hidden" id="password_hidden">
              <div class="form-group">
                <label for="password">Password</label>
                <div class="col-sm-9">
                  <input name="passwordnew" class="form-control" type="password" required="" id="passwordnew" placeholder="Input new password for user">
                </div>
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
                            <label for="emailaddress">Email : </label>
                            <input class="form-control" type="email" id="emaildaftar" required="" placeholder="email@domain.com" name="email">
                        </div>
                    </div>

                      <div class="form-group m-b-25">
                          <div class="col-12">
                              <label for="username">Name</label>
                              <input class="form-control" type="text" id="namadaftar" placeholder="Name">
                          </div>
                      </div>

                      <div class="form-group m-b-25">
                          <div class="col-12">
                            <label for="emailAddress">Roles : <span class="text-danger">*</span></label>
                            <select id="rolesdaftar" class="form-control" name="roles_id">
                                <?php $rolestable = DB::table('roles')->get(); ?>
                                @foreach ($rolestable as $roles)
                                <option value="{{$roles->id}}">{{$roles->namaRule}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>

                      <div style="padding-top:10px">
                      </div>


                      <div class="form-group m-b-25">
                          <div class="col-12">
                              <label for="password">Password</label>
                              <input name="password" class="form-control" type="password" required="" id="passworddaftar" placeholder="password">
                          </div>
                      </div>

                      <div class="form-group account-btn text-center m-t-10">
                          <div class="col-12">
                              <button id="submit" class="btn w-lg btn-rounded btn-primary waves-effect waves-light" type="submit">Register</button>
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
  document.getElementById('password_hidden').style.visibility = "hidden";
  $(document).ready(function() {

    // DataTable
    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('perusahaan/user/json') }}',
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'nama', name: 'nama'},
            {data: 'email', name: 'email'},
            {data: 'avatar_images', name: 'avatar_images',orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // ShowModals
    $(document).on('click', '.edit-modal', function() {
          $('#footer_action_button').text("Edit");
          $('#footer_action_button').addClass('glyphicon-check');
          $('#footer_action_button').removeClass('glyphicon-trash');
          $('.actionBtn').addClass('btn-success');
          $('.actionBtn').removeClass('btn-danger');
          $('.actionBtn').addClass('edit');
          $('.modal-title').text('Edit User');
          $('.deleteContent').hide();
          $('.form-horizontal').show();
          $('#fid').val($(this).data('id'));
          $('#n').val($(this).data('nama'));
          $('#eml').val($(this).data('email'));
          $('#avatar').val($(this).data('avatar'));
          $('#myModal').modal('show');
      });

      $(document).on('click', '.edit-modal2', function() {
            $('#footer_action_button2').text("Edit");
            $('#footer_action_button2').addClass('glyphicon-check');
            $('#footer_action_button2').removeClass('glyphicon-trash');
            $('.actionBtn2').addClass('btn-success');
            $('.actionBtn2').removeClass('btn-danger');
            $('.actionBtn2').addClass('edit');
            $('.modal-title2').text('Edit User');
            $('.deleteContent2').hide();
            $('.form-horizontal2').show();
            $('#fid2').val($(this).data('id'));
            $('#n2').val($(this).data('nama'));
            $('#eml2').val($(this).data('email'));
            $('#avatar2').val($(this).data('avatar'));
            $('#myModal2').modal('show');
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
          $('.dname').html($(this).data('name'));
          $('#myModal').modal('show');
      });
      $(document).on('click', '#tambah', function() {
          $('#signup-modal').modal('show');
      });

      $('.modal-footer').on('click', '.edit', function() {
          $.ajax({
              type: "POST",
              <?php
              $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
               ?>
              url: "{{$link}}/auth/edituser",
              dataType: "json",
              data: {
                '_token': $('input[name=_token]').val(),
                id: $("#fid").val(),
                email: $("#eml").val(),
                nama: $("#n").val(),
                avatar: $("#avatar").val(),
                roles_id: $('select[name=roles_id2]').val(),
                passwordnew: $("#passwordnew").val(),
              },
              success: function (data, status) {
                  document.getElementById('passwordnew').value = "";
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
              url: "{{$link}}/auth/delete",
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
            url: "{{$link}}/auth/register",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              email: $("#emaildaftar").val(),
              nama: $("#namadaftar").val(),
              avatar: "avatar/avatar.png",
              roles_id: $('select[name=roles_id]').val(),
              password: $("#passworddaftar").val(),
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
