@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","qwe")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("frontmenu")->where("method","=","qwe")->first()->content !!}
@endsection
