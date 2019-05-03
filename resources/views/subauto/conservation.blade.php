@extends("layouts.flayout")

@section("title")
  {{DB::table("ourfocusa")->where("method","=","conservation")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("ourfocusa")->where("method","=","conservation")->first()->content !!}
@endsection
