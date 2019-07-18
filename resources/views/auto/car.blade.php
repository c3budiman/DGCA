@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","car")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("frontmenu")->where("method","=","car")->first()->content !!}
@endsection
