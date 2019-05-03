@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","kontak")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("frontmenu")->where("method","=","kontak")->first()->content !!}
@endsection
