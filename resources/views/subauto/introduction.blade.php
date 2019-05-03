@extends("layouts.flayout")

@section("title")
  {{DB::table("ourfocusa")->where("method","=","introduction")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("ourfocusa")->where("method","=","introduction")->first()->content !!}
@endsection
