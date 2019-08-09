@php
  $logo = DB::table('setting_situses')->where('id','=','1')->get()->first()->logo;
@endphp
@extends('layouts.dlayout')

@section('title')
  Berita
@endsection

@section('content')
  <div class="card-box">
    <form enctype="multipart/form-data" action="{{url(action("WebAdminController@postBerita"))}}" method="post" class="form-horizontal ">
    <div class="pull-right">
        <button type="submit" name="button" class="btn btn-success"><i class="fa fa-upload"></i> Publish</button>
    </div>
      <h4 class="header-title m-t-0">Menambah Berita</h4>

      <p class="text-muted font-14 m-b-10">
         Disini kamu bisa menambah berita untuk app
      </p>
          {{ csrf_field() }}
          <div class="form-group row">
              <label class="col-3 col-form-label">Judul Berita : </label>
              <div class="col-9">
                  <input name="judul" type="text" required class="form-control" value="">
              </div>
          </div>
          <div class="form-group row">
              <div class="col-12">
                <textarea cols="10" rows="10" id="my-editor" name="content" class="form-control"></textarea>
              </div>
          </div>
      </form>
  </div>
  <!--  end row -->

  <script src="templateEditor/ckeditor/ckeditor.js"></script>
  <script>
    var options = {
      filebrowserImageBrowseUrl: '/starlingresource/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '/starlingresource/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '/starlingresource/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '/starlingresource/laravel-filemanager/upload?type=Files&_token='
    };
  </script>
  <script>
    CKEDITOR.replace('my-editor', options);
  </script>
@endsection
