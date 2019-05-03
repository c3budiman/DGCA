@extends('layouts.dlayout')

@section('title')
  {{Auth::User()->nama}}'s Profile
@endsection

@section('content')
  <?php
    $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
  ?>
  <div class="row">
      <div class="col-sm-12">
          <!-- meta -->
          <div class="profile-user-box card-box bg-custom">
              <div class="row">
                  <div class="col-sm-6">
                    @if (Auth::User()->avatar != null || Auth::User()->avatar != "")
                      <span class="pull-left mr-3"><img src="{{Auth::User()->avatar}}" alt="" class="thumb-lg rounded-circle"></span>
                    @else
                      <span class="pull-left mr-3"><img src="http://via.placeholder.com/128x128" alt="" class="thumb-lg rounded-circle"></span>
                    @endif

                      <div class="media-body text-white">
                          <h4 class="mt-1 mb-1 font-18">{{Auth::User()->nama}}</h4>
                          <?php
                            $roles_id = Auth::User()->roles_id;
                            $namaRule = DB::table('roles')->where('id','=', $roles_id)->first()->namaRule;
                          ?>
                          <p class="font-13 text-light">{{$namaRule}}</p>
                          <p class="text-light mb-0">{{Auth::User()->email}}</p>
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="text-right">
                          <a href="{{$link}}/editprofile" type="button" class="btn btn-light waves-effect">
                              <i class="mdi mdi-account-settings-variant mr-1"></i> Edit Profile
                          </a>
                      </div>
                  </div>
              </div>
          </div>
          <!--/ meta -->
      </div>
  </div>
@endsection
