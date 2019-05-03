@extends("layouts.flayout")

@section("title")
  {{DB::table("our_service")->where("method","=","project_development_and_management")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("our_service")->where("method","=","project_development_and_management")->first()->content !!}
@endsection
