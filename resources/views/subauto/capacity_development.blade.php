@extends("layouts.flayout")

@section("title")
  {{DB::table("our_service")->where("method","=","capacity_development")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("our_service")->where("method","=","capacity_development")->first()->content !!}
@endsection
