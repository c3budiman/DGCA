<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
  $judul = DB::table('setting_situses')->where('id','=','1')->first()->namaSitus;
  $favicon =DB::table('setting_situses')->where('id','=','1')->first()->favicon;
  $footer =DB::table('setting_situses')->where('id','=','1')->first()->footer;
  $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset($favicon)}}">
        {{-- <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script> --}}
        <!-- App css -->
        <link href="{{URL::asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ URL::asset('assets/js/modernizr.min.js') }}"></script>
        <!-- DataTables -->
        <link href="{{URL::asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{URL::asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert css -->
        <link href="{{URL::asset('plugins/sweet-alert/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap fileupload css -->
        <link href="{{URL::asset('plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />



        @yield('css')
        @yield('csstambahan')
        <link href="{{URL::asset('plugins/jquery.steps/css/jquery.steps.css') }}" rel="stylesheet" />
        <!-- Table Responsive css -->
        <link href="{{URL::asset('plugins/responsive-table/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css" media="screen">
        <link href="{{URL::asset('assets/css/smart_wizard.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/smart_wizard_theme_dots.css') }}" rel="stylesheet" type="text/css" />

        @yield('meta')
    </head>
    <body>
        <div id="wrapper">
            <div class="left side-menu">

                <div class="slimscroll-menu" id="remove-scroll">
                    <div class="topbar-left">
                        <a href="{{$link}}" class="logo">
                            <span>
                                <img src="{{ asset($logo)}}" alt="" height="80px">
                            </span>
                            <i>
                                <img src="{{ asset($logo)}}" alt="" width="70px">
                            </i>
                            <span style="color:#2c176e">DGCA</span>
                        </a>
                    </div>

                    <div style="margin-top:10px;margin-bottom:-10px" class="user-box">
                        <div style="margin-bottom:-5px;" class="user-img">
                          @if (Auth::User()->avatar != null || Auth::User()->avatar != "")
                            <img style="max-height:50px !important; width:50px; height:50px;" src="{{asset(Auth::User()->avatar)}}" alt="user-img" class="rounded-circle">
                          @else
                            <img src="http://via.placeholder.com/128x128" alt="user-img" class="rounded-circle img-fluid">
                          @endif

                        </div>
                        <h5><a href="#">{{Auth::User()->nama}}</a></h5>
                        <?php
                          $roles_id = Auth::User()->roles_id;
                          $namaRule = DB::table('roles')->where('id','=', $roles_id)->first()->namaRule;
                          $dashboardMenu = DB::table('dashmenu')->where('kepunyaan','=', $roles_id)->get();
                        ?>
                        <p class="text-muted">{{$namaRule}}</p>
                    </div>
                    <div id="sidebar-menu">
                      <ul class="metismenu" id="side-menu">
                    @foreach ($dashboardMenu as $dmenu)
                              <!--<li class="menu-title">Navigation</li>-->
                              @if(DB::table('submenu')->where('kepunyaan','=', $dmenu->id)->count() > 0)
                                <?php
                                  $dashboardChild = DB::table('submenu')->where('kepunyaan','=', $dmenu->id)->get();
                                ?>
                                <li>
                                    <a href="javascript: void(0);"><i class="{{$dmenu->class_css}}"></i><span> {{$dmenu->nama}} </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        @foreach ($dashboardChild as $dchild)
                                          <li><a href="{{$dchild->link}}">{{$dchild->nama}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                @else
                                  <li>
                                      <a href="{{$dmenu->link}}">
                                          <i class="{{$dmenu->class_css}}"></i><span> {{$dmenu->nama}} </span>
                                      </a>
                                  </li>
                              @endif
                  @endforeach
                          </ul>
                        </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="content-page">
                <div class="topbar">

                    <nav class="navbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">

                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                   @if (Auth::User()->avatar != null || Auth::User()->avatar != "")
                                     <img src="{{asset(Auth::User()->avatar)}}" alt="user" class="rounded-circle"> <span class="ml-1">{{Auth::User()->nama}}<i class="mdi mdi-chevron-down"></i> </span>
                                   @else
                                     <img src="http://via.placeholder.com/128x128" alt="user" class="rounded-circle"> <span class="ml-1">{{Auth::User()->nama}}<i class="mdi mdi-chevron-down"></i> </span>
                                   @endif

                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="{{$link}}/myprofile" class="dropdown-item notify-item">
                                        <i class="fi-head"></i> <span>My Account</span>
                                    </a>

                                    <!-- item-->
                                    {{-- <a href="{{$link}}/support" class="dropdown-item notify-item">
                                        <i class="fi-help"></i> <span>Support</span>
                                    </a> --}}

                                    <!-- item-->
                                    <a href="{{$link}}/logout" class="dropdown-item notify-item">
                                        <i class="fi-power"></i> <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>

                        <ul class="list-inline menu-left mb-0">
                            <li class="float-left">
                                <button class="button-menu-mobile open-left disable-btn">
                                    <i class="dripicons-menu"></i>
                                </button>
                            </li>

                        </ul>

                    </nav>

                </div>
                <!-- Top Bar End -->



                <!-- Start Page content -->
                <div class="content">
                    <div class="container-fluid">
                      @yield('content')

                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div> <!-- container -->
                </div> <!-- content -->
                <footer class="footer text-right">
                  <p class="account-copyright"> {!!$footer!!}</p>
                </footer>
            </div>

        </div>
        <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/waves.js') }}"></script>
        <script src="{{ URL::asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('assets/js/jquery.smartWizard.js') }}"></script>

        <script src="{{ URL::asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ URL::asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ URL::asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

        <script src="{{ URL::asset('plugins/jquery.steps/js/jquery.steps.min.js') }}"></script>
        <script src="{{ URL::asset('assets/pages/jquery.wizard-init.js') }}"></script>

        <script src="{{ URL::asset('plugins/jquery-knob/jquery.knob.js') }}"></script>
        <!-- Required datatable js -->
        <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

        <script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
        @yield('js')
        <!-- Counter Up  -->
        <script src="{{ URL::asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
        <script src="{{ URL::asset('plugins/counterup/jquery.counterup.min.js') }}"></script>
        <!-- responsive-table-->
        <script src="{{ URL::asset('plugins/responsive-table/js/rwd-table.min.js') }}" type="text/javascript"></script>


        <!-- App js -->
        <script src="{{ URL::asset('assets/js/jquery.core.js') }}"></script>
        <script src="{{ URL::asset('assets/js/jquery.app.js') }}"></script>


        @yield('jstambahan')


    </body>
</html>
