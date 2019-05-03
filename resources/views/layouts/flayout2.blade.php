<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
    $judul = DB::table('setting_situses')->where('id','=','1')->first()->namaSitus;
    $desc = DB::table('setting_situses')->where('id','=','1')->first()->slogan;
    $favicon =DB::table('setting_situses')->where('id','=','1')->first()->favicon;
    $footer =DB::table('setting_situses')->where('id','=','1')->first()->footer;
    $footer2 =DB::table('setting_situses')->where('id','=','1')->first()->footer2;
    $link = DB::table('setting_situs')->where('id','=','1')->first()->base_url;
  ?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8" />
  <title>{{$judul}} - @yield('title')</title>
  {{-- <link rel="shortcut icon" type="image/x-icon" href="https://static1.squarespace.com/static/59562732f7e0ab94574ba86a/t/59bd22149f7456435f7ea50d/favicon.ico"/> --}}
  <link rel="canonical" href="http://www.moores-rowland.com/starlingresource"/>
  <meta property="og:site_name" content="{{$judul}}"/>
  <meta property="og:title" content="{{$judul}}"/>
  <meta property="og:url" content="{{$link}}"/>
  <meta property="og:type" content="website"/>
  <meta property="og:description" content="{{$desc}}"/>
  <meta itemprop="name" content="{{$judul}}"/>
  <meta itemprop="url" content="{{$link}}"/>
  <meta itemprop="description" content="{{$desc}}"/>
  <meta name="twitter:title" content="{{$judul}}"/>
  <meta name="twitter:url" content="{{$link}}"/>
  <meta name="twitter:card" content="summary"/>
  <meta name="twitter:description" content="{{$desc}}"/>
  <meta name="description" content="{{$desc}}" />

  <!-- Favicons -->
  <link href="{{$link}}/..{{$favicon}}" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="{!! asset('assets/lib/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="{!! asset('assets/lib/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet">
  <link href="{!! asset('assets/lib/animate/animate.min.css') !!}" rel="stylesheet">
  <link href="{!! asset('assets/lib/ionicons/css/ionicons.min.css') !!}" rel="stylesheet">
  <link href="{!! asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') !!}" rel="stylesheet">
  <link href="{!! asset('assets/lib/lightbox/css/lightbox.min.css') !!}" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="{!! asset('assets/css/bizstyle.css') !!}" rel="stylesheet">
  @yield('csstambahan')
  @yield('metatambahan')
</head>

<body>

  <!--==========================
    Header
  ============================-->
  <header id="header" class="header-scrolled">
    <div class="container-fluid">

      <div id="logo" class="pull-left">
        {{-- <h1><a href="{{$link}}" class="scrollto">{{$judul}}</a></h1> --}}
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="{{$link}}"><img src=" {!! asset('/assets/img/Starling_Resources_Logo_Landscape.png') !!}" alt="" title="" style="max-width: 400px;max-height: 180px;margin-top: -28%;margin-left: 10%;" /></a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <?php
          //$menu = DB::table('submenu')->where('link', 'like', '/starlingresource/pages/%')->orderBy('id', 'asc')->groupBy('link')->get();
          $menu = DB::table('frontmenu')->select('id','nama','method')->orderBy('id', 'asc')->get();
          //dd();
           ?>
           @foreach ($menu as $mn)
             @if (DB::table($mn->method)->count() > 0)
               <?php
               $sub = DB::table($mn->method)->select('id','nama','method')->orderBy('id', 'asc')->get();
                ?>
                  @if ($sub)
                      @if ($mn->method=="our_service")
                        @if (Request::path() == $mn->method)
                          <li><a class="menu-active" href="{{$link}}/{{$mn->method}}">{{$mn->nama}}</a></li>
                        @else
                          <li><a href="{{$link}}/{{$mn->method}}">{{$mn->nama}}</a></li>
                        @endif
                      @else
                        <li class="menu-has-children"><a href="{{$link}}/{{$mn->method}}">{{$mn->nama}}</a>
                      @endif
                    @else
                      <li><a href="{{$link}}/{{$mn->method}}">{{$mn->nama}}</a></li>
                  @endif
                  <ul>

               @foreach ($sub as $s)
                 <?php
                   if ($mn->method=="our_service") {
                     continue;
                   }
                 ?>
                 <li><a href="{{$link}}/{{$mn->method}}/{{$s->method}}">{{$s->nama}}</a></li>
               @endforeach
                 </ul>
               </li>
             @else
               <?php
               if ($mn->method=="pageswhoweare") {
                 continue;
               }
               if ($mn->method=="pagesourmission") {
                 continue;
               }
               if ($mn->method=="pageshowwemakechange") {
                 continue;
               }
                ?>
                @if ($mn->method == Request::path())
                  <li class="menu-active"><a href="{{$link}}/{{$mn->method}}">{{$mn->nama}}</a></li>
                @else
                  <li><a href="{{$link}}/{{$mn->method}}">{{$mn->nama}}</a></li>
                @endif

             @endif
           @endforeach

        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <main id="main">

    <div style="margin-top:100px">

    </div>
        @yield('content')

  </main>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
          <div class="container">
            <div class="row">
              <div class="col-lg-6 col-md-6 footer-links">
                <h4>Useful Links</h4>
                <ul>
                  <li><i class="ion-ios-arrow-right"></i> <a href="#">DKPPU</a></li>
                  <li><i class="ion-ios-arrow-right"></i> <a href="#">Airnav</a></li>
                  <li><i class="ion-ios-arrow-right"></i> <a href="#">DNP</a></li>
                </ul>
              </div>

              <div class="col-lg-6 col-md-6 footer-contact">
                <h4>Contact Us</h4>
                <p>
                  DIREKTORAT KELAIKUDARAAN <br>
                  DAN PENGOPERASIAN PESAWAT UDARA <br>
                  Jl. C3,
                  Komplek Bandar Udara Soekarno Hatta, <br>
                  Tangerang Banten 15126 <br>

                  <strong>Phone:</strong> +62 21 25566288, +62 21 25508887, +62 21 22566399<br>
                  <strong>Email:</strong> tatausahadkppu@gmail.com<br>
                </p>

                <div class="social-links">
                  <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                  <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                  <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                  <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
                  <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
                </div>

              </div>

            </div>
          </div>
        </div>

    <div class="container">
      <div class="copyright">
        {!! $footer !!}
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- Uncomment below i you want to use a preloader -->
  <!-- <div id="preloader"></div> -->

  <!-- JavaScript Libraries -->
  <script src="{!! asset('assets/lib/jquery/jquery.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/jquery/jquery-migrate.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/easing/easing.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/superfish/hoverIntent.js') !!}"></script>
  <script src="{!! asset('assets/lib/superfish/superfish.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/wow/wow.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/waypoints/waypoints.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/counterup/counterup.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/owlcarousel/owl.carousel.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/isotope/isotope.pkgd.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/lightbox/js/lightbox.min.js') !!}"></script>
  <script src="{!! asset('assets/lib/touchSwipe/jquery.touchSwipe.min.js') !!}"></script>
  <!-- Contact Form JavaScript File -->
  <script src="{!! asset('assets/contactform/contactform.js') !!}"></script>

  <!-- Template Main Javascript File -->
  <script src="{!! asset('assets/js/main2.js') !!}"></script>

  <script type="text/javascript">
      $(document).ready(function () {
      $('.hmenu a').click(function () {
          //removing the previous selected menu state
          $('.hmenu').find('li.active').removeClass('active');
          //adding the state for this parent menu
          $(this).parents("li").addClass('active');
      });
    });
  </script>

  @yield('jstambahan')

</body>
</html>
