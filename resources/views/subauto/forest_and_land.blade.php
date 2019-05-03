@extends("layouts.flayout")

@section("title")
  {{DB::table("ourfocusa")->where("method","=","forest_and_land")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("ourfocusa")->where("method","=","forest_and_land")->first()->content !!}
@endsection
