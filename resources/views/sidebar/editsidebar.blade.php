@extends('layouts.dlayout')

@section('title')
  Editing Sidebar Menu For Backend
@endsection

@section('content')
  <?php
  $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
   ?>
  <div class="content">
      <div class="container-fluid">

          <div class="row">
              <div class="col-12">
                  <div class="card-box">
                      <h4 class="m-t-0 header-title">Editing Sidebar Menu : {{$sidebar->nama}}</h4>
                      <p class="text-muted font-14 m-b-30">
                          Editing Sidebar Menu : {{$sidebar->nama}}, to edit sidebar name`s and route, click edit on edit sidebar tab, and for managing submenu click edit/add submenu tab.
                      </p>

                      <ul class="nav nav-pills navtab-bg nav-justified pull-in ">
                          <li class="nav-item">
                              <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                  <i class="fi-monitor mr-2"></i> Edit Sidebar
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#profile1" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                  <i class="fi-head mr-2"></i> Edit/Add Submenu
                              </a>
                          </li>
                      </ul>
                      <div class="tab-content">
                          <div class="tab-pane show active" id="home1">
                              <div class="card-box table-responsive">
                                  <form action="{{$link}}/sidebar/{{$sidebar->id}}" method="post">
                                    {{ csrf_field() }}
                                      <div class="form-group">
                                          <label for="namasidebar">Sidebar`s Name<span class="text-danger">*</span></label>
                                          <input type="text" name="nama" parsley-trigger="change" required value="{{$sidebar->nama}}" class="form-control">
                                      </div>
                                      <div class="form-group">
                                          <label for="emailAddress">Used by : <span class="text-danger">*</span></label>
                                          <select class="form-control" name="roles_id">
                                              <?php $rolestable = DB::table('roles')->get(); ?>
                                              <option value="{{$sidebar->kepunyaan}}">{{DB::table('roles')->where('id','=',$sidebar->kepunyaan)->first()->namaRule}}</option>
                                              @foreach ($rolestable as $roles)
                                                @continue($roles->id === $sidebar->kepunyaan)
                                              <option value="{{$roles->id}}">{{$roles->namaRule}}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="pass1">Icon class : <span class="text-danger">*</span></label>
                                          <input name="class_css" value="{{$sidebar->class_css}}" required class="form-control">
                                      </div>
                                      <div class="form-group">
                                          <label for="passWord2">Link/URL <span class="text-danger">*</span></label>
                                          <input name="link" required class="form-control" value="{{$sidebar->link}}">
                                      </div>

                                      <div class="form-group text-right m-b-0">
                                          <button class="btn btn-custom waves-effect waves-light" type="submit">
                                              <i class="fa fa-edit"> </i> Edit
                                          </button>
                                          <a href="{{$link}}/sidebarsettings" class="btn btn-light waves-effect m-l-5">Cancel</a>
                                      </div>
                                      <input type="hidden" name="_method" value="PUT">
                                  </form>
                              </div>
                          </div>
                          <div class="tab-pane" id="profile1">
                            <div class="col-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title">Editing sidebar : {{$sidebar->nama}}</h4>
                                    <p class="text-muted font-14 m-b-30">
                                        In this option, you can edit sidebar : {{$sidebar->nama}}
                                    </p>
                                    <div class="pull-right" style="margin-top:-80px">
                                        {{-- <a href="{{$link}}/addsubmenu/withid/{{$sidebar->id}}" class="btn btn-xs btn-success"> <i class="fa fa-plus"></i> Tambah</a> --}}
                                        <button type="button"  href="#" class="btn btn-xs btn-success" id="tambah"> <i class="fa fa-plus"></i> Add Submenu</button>
                                    </div>

                                    <table style="width:100%;" id="contoh" class="table table-bordered table-hover datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>URL</th>
                                                <th colspan="10%">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                          </div>
                      </div>
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
                          <label for="namasidebar">Submenu`s Name<span class="text-danger">*</span></label>
                          <input id="nama" type="text" name="nama" parsley-trigger="change" required placeholder="nama submenu" class="form-control">
                        </div>
                    </div>

                      <div class="form-group m-b-25">
                          <div class="col-12">
                            <label for="passWord2">Link/URL (change ... with url) <span class="text-danger">*</span></label>
                            <input id="link" name="link" type="text" required class="form-control" value="{{$sidebar->link}}/...">
                          </div>
                          <input id="idnya" type="hidden" name="" value="{{$sidebar->id}}">
                      </div>

                      <div class="modal-footer">
                        <button id="submit" class="btn btn-success" type="submit"> <i class="fa fa-plus"> </i> Add Submenu</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                          <span class='glyphicon glyphicon-remove'></span> Batal
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
          <form class="form-horizontal" role="form">
            {{ csrf_field() }}
            <div class="form-group">
              <label class="control-label col-sm-2" for="id">ID:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="fid" disabled>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="name">Name :</label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="n">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="name">Link: </label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="linknya">
              </div>
            </div>
          </form>

          <div class="deleteContent">
            Delete Sidebar id : <span class="hidden did"></span> ,
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
  <!-- Parsley js -->
  <script type="text/javascript" src="{{ URL::asset('plugins/parsleyjs/parsley.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();
    });
  </script>

  <script type="text/javascript">
  $(document).ready(function() {
      $('.datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{$link}}/submenu/json/{{$id}}',
          columns: [
              {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
              {data: 'nama', name: 'nama'},
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
            url: "{{$link}}/addsubmenu",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              nama: $("#nama").val(),
              id: $("#idnya").val(),
              link: $("#link").val(),
            },
            success: function (data, status) {
                $('#tambah-sidebar').modal('hide');
                $("#nama").val(''),
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
            $('#linknya').val($(this).data('link'));
            $('#myModal').modal('show');
        });

        $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: "POST",
                url: "{{$link}}/editsubmenu",
                dataType: "json",
                data: {
                  '_token': $('input[name=_token]').val(),
                  id: $("#fid").val(),
                  nama: $("#n").val(),
                  link: $("#linknya").val(),
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
              url: "{{$link}}/deletesubmenu",
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
