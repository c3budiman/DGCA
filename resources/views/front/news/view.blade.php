@extends("layouts.flayout")

@section("title")
  {{DB::table("frontmenu")->where("method","=","news_digest")->first()->nama}}
@endsection

@section("content")
<style media="screen">
pagination {
display: inline-block;
padding-left: 0;
margin: 20px 0;
border-radius: 4px
}

.pagination>li {
display: inline
}

.pagination>li>a,
.pagination>li>span {
position: relative;
float: left;
padding: 6px 12px;
margin-left: -1px;
line-height: 1.42857143;
color: #18d26e;
text-decoration: none;
background-color: #fff;
border: 1px solid #ddd
}

.pagination>li>a:focus,
.pagination>li>a:hover,
.pagination>li>span:focus,
.pagination>li>span:hover {
z-index: 2;
color: #23527c;
background-color: #eee;
border-color: #ddd
}

.pagination>li:first-child>a,
.pagination>li:first-child>span {
margin-left: 0;
border-top-left-radius: 4px;
border-bottom-left-radius: 4px
}

.pagination>li:last-child>a,
.pagination>li:last-child>span {
border-top-right-radius: 4px;
border-bottom-right-radius: 4px
}

.pagination>.active>a,
.pagination>.active>a:focus,
.pagination>.active>a:hover,
.pagination>.active>span,
.pagination>.active>span:focus,
.pagination>.active>span:hover {
z-index: 3;
color: #fff;
cursor: default;
background-color: #18d26e;
border-color: #18d26e
}

.pagination>.disabled>a,
.pagination>.disabled>a:focus,
.pagination>.disabled>a:hover,
.pagination>.disabled>span,
.pagination>.disabled>span:focus,
.pagination>.disabled>span:hover {
color: #777;
cursor: not-allowed;
background-color: #fff;
border-color: #ddd
}

.pagination-lg>li>a,
.pagination-lg>li>span {
padding: 10px 16px;
font-size: 18px;
line-height: 1.3333333
}

.pagination-lg>li:first-child>a,
.pagination-lg>li:first-child>span {
border-top-left-radius: 6px;
border-bottom-left-radius: 6px
}

.pagination-lg>li:last-child>a,
.pagination-lg>li:last-child>span {
border-top-right-radius: 6px;
border-bottom-right-radius: 6px
}

.pagination-sm>li>a,
.pagination-sm>li>span {
padding: 5px 10px;
font-size: 12px;
line-height: 1.5
}

.pagination-sm>li:first-child>a,
.pagination-sm>li:first-child>span {
border-top-left-radius: 3px;
border-bottom-left-radius: 3px
}

.pagination-sm>li:last-child>a,
.pagination-sm>li:last-child>span {
border-top-right-radius: 3px;
border-bottom-right-radius: 3px
}
</style>

  <?php $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus; ?>
  <section id="" >
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-sm-8 blog-content">
          <h2>{{$data->title}}</h2>
          <h5>{{$data->src}}</h5>
          {!! $data->content !!}
      </div>
      <?php
      $links = DB::table('news_text')
                ->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) post_count'))
                ->groupBy('year')
                ->groupBy('month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

       ?>
       <div class="col-md-3 col-sm-4">
         <h4>Post Archives</h4>
         <?php $i=0; $year=''; $count=0; $count_awal=0; ?>
         @foreach ($links as $ele)
           <?php $i++; ?>
           @if ($ele->year == $year)
             <?php $count=$count_awal + $count; continue; ?>
           @endif
           <?php
           $mont = DB::table('news_text')
                     ->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) post_count'))
                     ->groupBy('year')
                     ->groupBy('month')
                     ->orderBy('year', 'desc')
                     ->orderBy('month', 'desc')
                     ->having('year','=',$ele->year)
                     ->get();
                     $year = DB::table('news_text')
                               ->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) post_count'))
                               ->groupBy('year')
                               ->orderBy('year', 'desc')
                               ->orderBy('month', 'desc')
                               ->having('year','=',$ele->year)
                               ->get();
            ?>
           <a data-toggle="collapse" href="#news{{$ele->year}}"><i class="fa fa-chevron-circle-right"></i> {{$ele->year}} <span class="badge">({{$year[0]->post_count}})</span></a>
           <br>
            <div id="news{{$ele->year}}" class="panel-collapse collapse">
              <ul>

                 <?php $j=0; ?>
                 @foreach ($mont as $month)
                   <?php $j++; ?>
                   <li><a data-toggle="collapse" href="#{{$month->month_name}}{{$ele->year}}">{{$month->month_name}}</a></li>
                    <div id="{{$month->month_name}}{{$ele->year}}" class="panel-collapse collapse">
                      <ul>
                        <?php $newstitle = DB::table('news_text')->whereYear('created_at', '=', $ele->year)
                                                            ->whereMonth('created_at', '=', $month->month)
                                                            ->get();
                                                            ?>
                            @foreach ($newstitle as $news)
                              <li><a href="{{$link}}/news_digests/id/{{$news->id}}">{{$news->title}}</a></li>
                            @endforeach
                      </ul>
                    </div>
                 @endforeach
              </ul>
            </div>
            <?php $year = $ele->year; $count=0; ?>
         @endforeach
       </div>
      </div>
    </div>
  </section>
@endsection
