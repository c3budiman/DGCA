@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","faq")->first()->nama}}
@endsection

@section("content")
  {!! DB::table("frontmenu")->where("method","=","faq")->first()->content !!}
@endsection
