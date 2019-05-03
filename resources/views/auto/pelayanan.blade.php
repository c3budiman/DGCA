@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","pelayanan")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("frontmenu")->where("method","=","pelayanan")->first()->content !!}
@endsection
