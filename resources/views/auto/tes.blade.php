@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","tes")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("frontmenu")->where("method","=","tes")->first()->content !!}
@endsection
