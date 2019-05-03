@extends("layouts.flayout")

@section("title")
  {{DB::table("our_service")->where("method","=","framework_and_methodology_development")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("our_service")->where("method","=","framework_and_methodology_development")->first()->content !!}
@endsection
