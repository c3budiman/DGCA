@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","gallery")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("frontmenu")->where("method","=","gallery")->first()->content !!}
@endsection
