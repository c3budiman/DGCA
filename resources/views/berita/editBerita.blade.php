@php
  $logo = DB::table('setting_situses')->where('id','=','1')->get()->first()->logo;
@endphp
@extends('layouts.dlayout')

@section('title')
  Berita
@endsection

@section('content')
  <div class="card-box">
    <form enctype="multipart/form-data" action="/berita/{{$berita->id_berita}}/edit" method="post" class="form-horizontal ">
    <div class="pull-right">
        <button type="submit" name="button" class="btn btn-success"><i class="fa fa-upload"></i> Simpan</button>
    </div>
      <h4 class="header-title m-t-0">Mengedit Berita</h4>

      <p class="text-muted font-14 m-b-10">
         Disini kamu bisa mengedit berita untuk app
      </p>


          {{ csrf_field() }}
          <div class="form-group row">
              <label class="col-3 col-form-label">Judul Berita : </label>
              <div class="col-9">
                  <input name="judul" type="text" required class="form-control" value="{{$berita->judul}}">
              </div>
          </div>
          <div class="form-group row">
              <div class="col-12">
                <textarea cols="10" rows="10" id="my-editor" name="content" class="form-control">{{$berita->content}}</textarea>
              </div>
          </div>
          <input type="hidden" name="_method" value="PUT">
      </form>
  </div>
  <!--  end row -->

  <script src="{{ URL::asset('templateEditor/ckeditor/ckeditor.js') }}"></script>
  <script>
    var options = {
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };
  </script>
  <script>
    CKEDITOR.replace('my-editor', options);
  </script>
@endsection
