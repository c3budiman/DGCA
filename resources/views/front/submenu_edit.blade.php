@extends('layouts.dlayout')

@section('title')
  Editing Menu {{$front->nama}}
@endsection

@section('content')
  <?php
  $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
   ?>
   <link rel="stylesheet"
         href="{!! asset('assets/textarea/codemirror.css') !!}">
   <script src="{!! asset('assets/textarea/codemirror.js') !!}"></script>
  <div class="row">
      <div class="col-12">
          <div class="card-box">
              <h4 class="header-title m-t-0">Changing Menu "{{$front->nama}}" Appearence</h4>
              <p class="text-muted font-14 m-b-10">
                  You can change menu {{$front->nama}} Appearence in here.
              </p>
              <form enctype="multipart/form-data" action="{{$link}}/submenufront/edit" method="post" class="form-horizontal ">
                  {{ csrf_field() }}
                  <div class="form-group row">
                      <label class="col-3 col-form-label">Nama Menu : </label>
                      <div class="col-9">
                          <input name="nama" type="text" required class="form-control" value="{{$front->nama}}">
                      </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-3 col-form-label">Content : </label>

                      <div class="col-9">
                          <fieldset id='editor'> Editor :  <input style="margin-left:20px" type="radio" name="editor" value="simple"> Simple <input  style="margin-left:20px" type="radio" name="editor" value="advance"> advance </fieldset>
                          <br>
                          <br>
                          <textarea cols="10" rows="10" id="my-editor" name="content">{{$front->content}}</textarea>
                      </div>
                  </div>

                  <input type="hidden" name="id" value="{{$front->id}}">
                  <input type="hidden" name="parent" value="{{$front->parent}}">

                  <div class="form-group row">
                      <div class="col-12">
                          <div class="pull-right">
                              <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                          </div>
                      </div>
                  </div>
                  <input type="hidden" name="_method" value="PUT">
              </form>
          </div>
      </div>
  </div>
  <!--  end row -->

  {{-- Modals --}}
  <div id="tambah-sidebar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">

              <div class="modal-body">
                {{ csrf_field() }}

                    <div class="form-group m-b-25">
                        <div class="col-12">
                          <label for="namasidebar">Nama Submenu<span class="text-danger">*</span></label>
                          <input id="nama" type="text" name="nama" parsley-trigger="change" required placeholder="new submenu" class="form-control">
                        </div>
                    </div>

                      <div class="form-group m-b-25">
                          <div class="col-12">
                            <label for="passWord2">Method/URL (ganti ... dengan link) <span class="text-danger">*</span></label>
                            <input id="link" name="link" type="text" required class="form-control" placeholder="newsubmenu">
                          </div>
                          <input id="idnya" type="hidden" name="" value="{{$front->id}}">
                      </div>

                      <div class="modal-footer">
                        <button id="submit" class="btn btn-success" type="submit"> <i class="fa fa-plus"> </i> Tambah Submenu</button>
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
              <label class="control-label col-sm-2" for="name">Nama:</label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="n">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="name">Method: </label>
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
              <span class='glyphicon glyphicon-remove'></span> Batal
            </button>
          </div>


        </div>
      </div>
    </div>
  </div>
@endsection

@section('jstambahan')
  <?php
  $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
   ?>
  <script src="{!! asset('templateEditor/ckeditor/ckeditor.js') !!}"></script>
  <script>
    var options = {
      filebrowserImageBrowseUrl: '{{$link}}/filemanager?type=Images',
      filebrowserImageUploadUrl: '{{$link}}/filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '{{$link}}/filemanager?type=Files',
      filebrowserUploadUrl: '{{$link}}/filemanager/upload?type=Files&_token='
    };
  </script>

  <script>
  $(document).ready(function() {
     $('#my-editor').hide();
    //CKEDITOR.replace('my-editor', options);
    $('#editor input[type=radio]').change(function(){
        if ($(this).val() == "advance") {
          $('#my-editor').show();
          // var tes = $('#my-editor').html();
          // $('#my-editor').html(`<pre>${tes}</pre>`);
          var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('my-editor'),
          {
            lineNumbers : true,
            matchBrackets : true,
            tabMode: "indent",
            mode:  "htmlmixed"
          }
          );
          $('#editor').hide();
        } else {
          $('#my-editor').show();
          CKEDITOR.replace('my-editor', options);
          $('#editor').hide();
        }
    })
  });
  </script>

  <script type="text/javascript">
  $(document).ready(function() {
      $('.datatable').DataTable({
              "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian-Alternative.json"
          },
          processing: true,
          serverSide: true,
          ajax: '{{$link}}/{{$front->method}}/json',
          columns: [
              {data: 'id', name: 'id'},
              {data: 'nama', name: 'nama'},
              {data: 'method', name: 'method'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

      $(document).on('click', '#tambah', function() {
          $('#tambah-sidebar').modal('show');
      });

      $("#submit").click(function(){
        $.ajax({
            type: "POST",
            url: "{{$link}}/{{$front->method}}s",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              nama: $("#nama").val(),
              id: $("#idnya").val(),
              parent: "{{$front->id}}",
              method: $("#link").val(),
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
              url: "{{$link}}/deletesub/{{$front->method}}",
              dataType: "json",
              data: {
                '_token': $('input[name=_token]').val(),
                id: $("#iddelete").val(),
                method: "{{$front->method}}",
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

<!-- Bootstrap fileupload js -->
<script src="{!! asset('plugins/bootstrap-fileupload/bootstrap-fileupload.js') !!}"></script>
<!-- Sweet Alert Js  -->
<script src="{!! asset('plugins/sweet-alert/sweetalert2.min.js') !!}"></script>

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
@endsection
