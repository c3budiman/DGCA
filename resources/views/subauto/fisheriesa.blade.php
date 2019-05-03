@extends("layouts.flayout")

@section("title")
  {{DB::table("ourfocusa")->where("method","=","fisheriesa")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("ourfocusa")->where("method","=","fisheriesa")->first()->content !!}
@endsection
