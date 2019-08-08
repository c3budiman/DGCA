@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","pendaftaran")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("frontmenu")->where("method","=","pendaftaran")->first()->content !!}
@endsection
