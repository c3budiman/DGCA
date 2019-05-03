@extends("layouts.flayout")

@section("title")
  {{DB::table("our_service")->where("method","=","institutional_development")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("our_service")->where("method","=","institutional_development")->first()->content !!}
@endsection
