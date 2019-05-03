@extends("layouts.flayout")

@section("title")
  {{DB::table("ourfocusa")->where("method","=","climate_and_carbon")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("ourfocusa")->where("method","=","climate_and_carbon")->first()->content !!}
@endsection
