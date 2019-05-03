@extends("layouts.flayout")

@section("title")
  {{DB::table("our_service")->where("method","=","financing_and_business_planning")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("our_service")->where("method","=","financing_and_business_planning")->first()->content !!}
@endsection
