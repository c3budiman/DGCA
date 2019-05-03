@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","home")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("frontmenu")->where("method","=","home")->first()->content !!}
@endsection
