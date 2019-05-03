<?php
$logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
$link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
 ?>

@extends('layouts.dlayout')

@section('title')
  Add News
@endsection

@section('content')
  <div class="card-box">
    <form enctype="multipart/form-data" action="{{url(action("news_digestController@postNews"))}}" method="post" class="form-horizontal ">
    <div class="pull-right">
        <button type="submit" name="button" class="btn btn-success"><i class="fa fa-upload"></i> Publish</button>
    </div>
      <h4 class="header-title m-t-0">Adding News</h4>

      <p class="text-muted font-14 m-b-10">
         In this facility, you can add news for news digest page.
      </p>
          {{ csrf_field() }}
          <div class="form-group row">
              <label class="col-3 col-form-label">Title : </label>
              <div class="col-9">
                  <input name="title" type="text" required class="form-control" value="">
              </div>
          </div>
          <div class="form-group row">
              <label class="col-3 col-form-label">News Date : </label>
              <div class="col-9">
                  <input name="date" type="date" required class="form-control" value="{{date('Y-m-d')}}">
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
    CKEDITOR.replace('my-editor', options);
  </script>
@endsection
