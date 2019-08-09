<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
  $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
  $id = DB::table('frontmenu')->where('method','=','home')->first()->id;
  $content = DB::table('frontmenu')->where('method','=','home')->first()->content;
?>
@extends('layouts.dlayout')

@section('title')
  Managing Menu Home
@endsection

@section('content')
  <link rel="stylesheet"
        href="{!! asset('assets/textarea/codemirror.css') !!}">
  <script src="{!! asset('assets/textarea/codemirror.js') !!}"></script>
  {{ csrf_field() }}
  <div class="content">
      <div class="container-fluid">
          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h4 class="m-t-0 header-title">Managing Home Slide</h4>
                      <p class="text-muted font-14 m-b-30">
                          You can add, edit, and delete slider for frontend.
                      </p>
                      <div class="pull-right" style="margin-top:-50px">
                          {{-- <a href="/addsidebar" class="btn btn-xs btn-success"> <i class="fa fa-plus"></i> Tambah</a> --}}
                          <a class="btn btn-xs btn-success" href="{{$link}}/slider/add" id="tambah"> <i class="fa fa-plus"></i> Add New Slide</a>
                      </div>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Title</th>
                                  <th>Image</th>
                                  <th colspan="10%">Action</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h4 class="m-t-0 header-title">Managing Home Content</h4>
                      <p class="text-muted font-14 m-b-30">
                          You can add, edit, and delete slider for frontend.
                      </p>
                      <form enctype="multipart/form-data" action="{{$link}}/front/edit" method="post" class="form-horizontal ">
                          {{ csrf_field() }}

                          <div class="form-group row">
                              <label class="col-3 col-form-label">Content : </label>

                              <div class="col-9">
                                  <fieldset id='editor'> Editor :  <input style="margin-left:20px" type="radio" name="editor" value="simple"> Simple <input  style="margin-left:20px" type="radio" name="editor" value="advance"> advance </fieldset>
                                  <br>
                                  <br>
                                  <textarea cols="10" rows="10" id="my-editor" name="content">{{$content}}</textarea>
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-12">
                                  <div class="pull-right">
                                      <button type="submit" name="button" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                  </div>
                              </div>
                          </div>
                          <input type="hidden" name="nama" value="Home">
                          <input type="hidden" name="id" value="{{$id}}">
                          <input type="hidden" name="_method" value="PUT">
                      </form>
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
            Are you sure to delete slider : <span class="nama-kar"></span> ?
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
        processing: true,
        serverSide: true,
        ajax: '{{ route('slide/json') }}',
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'imagesnya', name: 'imagesnya'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
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
        $('.nama-kar').text($(this).data('nama'));
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        $('#iddelete').val($(this).data('id'));
        $('#myModal').modal('show');
    });

    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: "POST",
            url: "{{$link}}/slider/delete",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              id: $("#iddelete").val(),
            },
            success: function (data, status) {
              $(document).ready(function() {
                $('.datatable').DataTable().ajax.reload(null, false);
              });
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
