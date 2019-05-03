@extends('layouts.dlayout')

@section('title')
  Managing Sidebar Menu
@endsection

@section('content')
<?php
$link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
 ?>
  <!-- Start Page content -->
  <div class="content">
      <div class="container-fluid">

          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h4 class="m-t-0 header-title">Managing Sidebar Menu</h4>
                      <p class="text-muted font-14 m-b-30">
                          You can add, edit and delete sidebar menu for backend menu.
                      </p>
                      <div class="pull-right" style="margin-top:-50px">
                          {{-- <a href="{{$link}}/addsidebar" class="btn btn-xs btn-success"> <i class="fa fa-plus"></i> Tambah</a> --}}
                          <button type="button"  href="#" class="btn btn-xs btn-success" id="tambah"> <i class="fa fa-plus"></i> Add</button>
                      </div>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Sidebar`s Name</th>
                                  <th>Owner</th>
                                  <th>Icon</th>
                                  <th>Link/URL</th>
                                  <th colspan="10%">Action</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div id="tambah-sidebar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">

              <div class="modal-body">
                {{ csrf_field() }}

                    <div class="form-group m-b-25">
                        <div class="col-12">
                          <label for="namasidebar">Sidebar`s Name<span class="text-danger">*</span></label>
                          <input id="nama" type="text" name="nama" parsley-trigger="change" required placeholder="nama sidebar" class="form-control">
                        </div>
                    </div>

                      <div class="form-group m-b-25">
                          <div class="col-12">
                            <label for="emailAddress">Used by : <span class="text-danger">*</span></label>
                            <select id="rolesdaftar" class="form-control" name="roles_id">
                                <?php $rolestable = DB::table('roles')->get(); ?>
                                @foreach ($rolestable as $roles)
                                <option value="{{$roles->id}}">{{$roles->namaRule}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>

                      <div class="form-group m-b-25">
                          <div class="col-12">
                            <label for="pass1">Icon Name : <span class="text-danger">*</span></label>
                            <input id="thecss" name="thecss" type="text" placeholder="class css" required class="form-control">
                          </div>
                      </div>

                      <div class="form-group m-b-25">
                          <div class="col-12">
                            <label for="passWord2">Link/URL <span class="text-danger">*</span></label>
                            <input id="link" name="link" type="text" required class="form-control" placeholder="Link / URL">
                          </div>
                      </div>

                      <div class="modal-footer">
                        <button id="submit" class="btn btn-success" type="submit"> <i class="fa fa-plus"> </i> Add Sidebar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                          <span class='glyphicon glyphicon-remove'></span> Cancel
                        </button>
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
            Delete Sidebar with id : <span class="hidden did"></span> ,
            "<span class="dname"></span>" ?
              {{ csrf_field() }}
              <input type="hidden" id="iddelete">
          </div>



          <div class="modal-footer">
            <button type="button" class="btn actionBtn" data-dismiss="modal">
              <span id="footer_action_button" class='glyphicon'> </span>
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span> Cancel
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>

@endsection
@section('js')
  <script type="text/javascript">
  $(document).ready(function() {
      $('.datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route('sidebar/json') }}',
          columns: [
              {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
              {data: 'nama', name: 'nama'},
              {data: 'Owner', name: 'Owner', orderable: false, searchable: false},
              {data: 'realicon', name: 'realicon', orderable: false, searchable: false},
              {data: 'link', name: 'link'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      $(document).on('click', '#tambah', function() {
          $('#tambah-sidebar').modal('show');
      });

      $("#submit").click(function(){
        $.ajax({
            type: "POST",
            url: "{{$link}}/addsidebar",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              nama: $("#nama").val(),
              roles_id: $('select[name=roles_id]').val(),
              class_css: $("#thecss").val(),
              link: $("#link").val(),
            },
            success: function (data, status) {
                $('#tambah-sidebar').modal('hide');
                $("#nama").val(''),
                $("#thecss").val(''),
                $("#link").val(''),
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
            $('.dname').html($(this).data('nama'));
            $('#myModal').modal('show');
      });

      $('.modal-footer').on('click', '.delete', function() {
          $.ajax({
              type: "POST",
              url: "{{$link}}/sidebar/delete",
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


  });
  </script>
@endsection
