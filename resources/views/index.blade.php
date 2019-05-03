<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
    $judul = DB::table('setting_situses')->where('id','=','1')->first()->namaSitus;
    $desc = DB::table('setting_situses')->where('id','=','1')->first()->slogan;
    $favicon =DB::table('setting_situses')->where('id','=','1')->first()->favicon;
    $footer =DB::table('setting_situses')->where('id','=','1')->first()->footer;
    //$footer2 =DB::table('setting_situses')->where('id','=','1')->first()->footer2;
    $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
    $content = DB::table('frontmenu')->where('method','=','home')->first()->content;
  ?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8" />
  <title>{{$judul}}</title>
  {{-- <link rel="shortcut icon" type="image/x-icon" href="https://static1.squarespace.com/static/59562732f7e0ab94574ba86a/t/59bd22149f7456435f7ea50d/favicon.ico"/> --}}
  <link rel="canonical" href="http://www.moores-rowland.com/starlingresource"/>
  <meta property="og:site_name" content="{{$judul}}"/>
  <meta property="og:title" content="{{$judul}}"/>
  <meta property="og:url" content="{{$link}}"/>
  <meta property="og:type" content="website"/>
  <meta property="og:description" content="{{$desc}}"/>
  {{-- <meta property="og:image" content="http://static1.squarespace.com/static/59562732f7e0ab94574ba86a/t/59563dd5893fc0291b868a4a/1498824151583/systemiq+elements-02_cut.png?format=1500w"/> --}}
  {{-- <meta property="og:image:width" content="1500"/>
  <meta property="og:image:height" content="406"/> --}}
  <meta itemprop="name" content="{{$judul}}"/>
  <meta itemprop="url" content="{{$link}}"/>
  <meta itemprop="description" content="{{$desc}}"/>
  {{-- <meta itemprop="thumbnailUrl" content="http://static1.squarespace.com/static/59562732f7e0ab94574ba86a/t/59563dd5893fc0291b868a4a/1498824151583/systemiq+elements-02_cut.png?format=1500w"/>
  <link rel="image_src" href="http://static1.squarespace.com/static/59562732f7e0ab94574ba86a/t/59563dd5893fc0291b868a4a/1498824151583/systemiq+elements-02_cut.png?format=1500w" />
  <meta itemprop="image" content="http://static1.squarespace.com/static/59562732f7e0ab94574ba86a/t/59563dd5893fc0291b868a4a/1498824151583/systemiq+elements-02_cut.png?format=1500w"/> --}}
  <meta name="twitter:title" content="{{$judul}}"/>
  {{-- <meta name="twitter:image" content="http://static1.squarespace.com/static/59562732f7e0ab94574ba86a/t/59563dd5893fc0291b868a4a/1498824151583/systemiq+elements-02_cut.png?format=1500w"/> --}}
  <meta name="twitter:url" content="{{$link}}"/>
  <meta name="twitter:card" content="summary"/>
  <meta name="twitter:description" content="{{$desc}}"/>
  <meta name="description" content="{{$desc}}" />

  <!-- Favicons -->
  <link href="{{$link}}/..{{$favicon}}" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
  <link href="assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="assets/css/bizstyle.css" rel="stylesheet">

  <style media="screen">
  .btn-info2 {
      color: #fff;
      background-color: #3A6D8E;
      border-color: #3A6D8E;
  }
  .btn-success {
    color: #fff;
    background-color: #5EC1A4 ;
    border-color: #5EC1A4 ;
}

  .post-slide{
    background: #fff;
    padding-bottom: 20px;
    margin: 0 15px;
    margin-right: 20px;
}
.post-slide .post-img{
    position:relative;
}
.post-slide .over-layer{
    background: rgba(0, 0, 0, 0.6);
    width: 100%;
    height: 100%;
    position: absolute;
    opacity:0;
    cursor: pointer;
    transition: all 0.30s ease 0s;
}
.post-slide:hover .over-layer{
    opacity:1;
}
.post-slide .over-layer:after{
    content: "+";
    font-size: 52px;
    color: #fff;
    position: absolute;
    top: 31%;
    left:42%;
}
.post-slide .post-img img{
    width: 100%;
    height: auto;
}
.post-slide .post-title{
    margin:25px 0 15px 0;
}
.post-slide .post-title:before{
    content:"";
    border:2px solid #e67e22;
    width:18%;
    display: block;
    margin-bottom:15px;
}
.post-slide .post-title a{
    font-size: 14px;
    font-weight:bold;
    color:#333;
    display: inline-block;
    text-transform:capitalize;
    transition: all 0.3s ease 0s;
}
.post-slide .post-title a:hover{
    text-decoration: none;
    color:#e67e22;
}
.post-slide .post-date{
    text-transform:capitalize;
}
.post-slide .post-date:before{
    content: "\f073";
    font-family: "Font Awesome 5 Free"; font-weight: 900;
    margin-right: 7px;
    color:#e67e22;
}
.owl-theme .owl-controls .owl-page.active span, .owl-theme .owl-controls.clickable .owl-page:hover span{
    background: #e67e22;
}

hr.separator {
    width: 95%;
    height: 1px;
    position: absolute;
    margin-top: 18px;
    z-index: -1;
}

button.see-all {
    border: 1px solid #b7b7b7;
    border-radius: 69px;
    background: #757575;
    font-size: 12px;
    color: #fff;
    position: absolute;
}

  </style>

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
        <a href="{{$link}}"><img src="https://imsis-djpu.dephub.go.id/regdrone/assets/web/images/logo22.png" alt="" title="" style="max-width: 200px;max-height: 70px;margin-top: -28%;margin-left: 10%;" /></a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <?php
          //$menu = DB::table('submenu')->where('link', 'like', '/starlingresource/pages/%')->orderBy('id', 'asc')->groupBy('link')->get();
          $menu = DB::table('frontmenu')->select('id','nama','method')->orderBy('id', 'asc')->get();
          //dd();
          //dd(Request::path());
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

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro">
    <div class="intro-container">
      <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner" role="listbox">


          <?php $slide = DB::table("slider")->get(); ?>
          <?php $s=0; ?>
          @foreach ($slide as $sl)
            @if ($s == 0)
              <div class="carousel-item active">
                <div class="carousel-background"><img style="width:100%" src="{{$sl->image}}" alt=""></div>
                <div class="carousel-container">
                  <div class="carousel-content">
                    <h2>{{$sl->title}}</h2>
                  </div>
                </div>
              </div>
            @else
              <div class="carousel-item">
                <div class="carousel-background"><img style="width:100%" src="{{$sl->image}}" alt=""></div>
                <div class="carousel-container">
                  <div class="carousel-content">
                    <h2>{{$sl->title}}</h2>
                  </div>
                </div>
              </div>
            @endif
            <?php $s=1; ?>

          @endforeach




        </div>

        <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
          <span style="visibility: hidden;" class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>

        <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
          <span style="visibility: hidden;" class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

      </div>
    </div>
  </section><!-- #intro -->

  <main id="main">

    {!!$content!!}

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
  <script src="assets/lib/jquery/jquery.min.js"></script>
  <script src="assets/lib/jquery/jquery-migrate.min.js"></script>
  <script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/lib/easing/easing.min.js"></script>
  <script src="assets/lib/superfish/hoverIntent.js"></script>
  <script src="assets/lib/superfish/superfish.min.js"></script>
  <script src="assets/lib/wow/wow.min.js"></script>
  <script src="assets/lib/waypoints/waypoints.min.js"></script>
  <script src="assets/lib/counterup/counterup.min.js"></script>
  <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="assets/lib/isotope/isotope.pkgd.min.js"></script>
  <script src="assets/lib/lightbox/js/lightbox.min.js"></script>
  <script src="assets/lib/touchSwipe/jquery.touchSwipe.min.js"></script>
  <!-- Contact Form JavaScript File -->
  <script src="assets/contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="assets/js/main.js"></script>

  <script type="text/javascript">
      $(document).ready(function () {
      $('.hmenu a').click(function () {
          //removing the previous selected menu state
          $('.hmenu').find('li.active').removeClass('active');
          //adding the state for this parent menu
          $(this).parents("li").addClass('active');
      });
    });

    $(document).ready(function() {
        $("#news-slider").owlCarousel({
            items : 4,
            itemsDesktop:[1199,3],
            itemsDesktopSmall:[980,2],
            itemsMobile : [600,1],
            pagination:true,
            autoPlay:true
        });
    });
  </script>
  <script src="plugins/sweet-alert/sweetalert2.min.js"></script>

@if (session('status'))
  <script type="text/javascript">
  alert('{{ session('status') }}')
  </script>
@endif

</body>
</html>
