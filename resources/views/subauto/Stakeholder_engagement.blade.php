@extends("layouts.flayout")

@section("title")
  {{DB::table("our_service")->where("method","=","stakeholder_engagement")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("our_service")->where("method","=","stakeholder_engagement")->first()->content !!}
@endsection
