<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
?>
@extends('layouts.dlayout')

@section('title')
  Approval Data
@endsection

@section('css')
  <script src="{{ asset('js/app2.js') }}"></script>
@endsection

@section('content')
  <!-- Start Page content -->
  <div class="content">
      <div class="container-fluid">

          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h4 class="m-t-0 header-title">Rincian UAS</h4>
                      <br>
                      <form action="/approvaldrones/{{$drones->id}}" role="form" method="post">
                      <input type="hidden" name="_method" value="put">
                      {{ csrf_field() }}
                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <tbody>
                              <tr>
                                  <td>Nama Pengusul</td>
                                  @if (Auth::User()->roles_id == 3)
                                    <td> <a href="{{url('/').'/identitas/'}}">{{DB::table('users')->where('id','=',$drones->user_id)->first()->nama}}</a> </td>
                                  @else
                                    <td> <a href="{{url('/').'/detail/identitas/'.$drones->user_id}}">{{DB::table('users')->where('id','=',$drones->user_id)->first()->nama}}</a> </td>
                                  @endif
                              </tr>
                              <tr>
                                  <td>Foto Drone</td>
                                  <td><a href="{{json_decode($drones->pic_of_drones)->original}}"> <img height="100px" src="{{json_decode($drones->pic_of_drones)->resized}}" alt=""> </a></td>
                              </tr>
                              <tr>
                                  <td>Foto Serial Nomor Drone</td>
                                  <td><a href="{{json_decode($drones->pic_of_drones_with_sn)->original}}"> <img height="100px" src="{{json_decode($drones->pic_of_drones_with_sn)->resized}}" alt=""> </a></td>
                              </tr>
                              <tr>
                                  <td>Foto Bukti Penguasaan Pesawat Udara Tanpa Awak</td>
                                  <td><a href="{{json_decode($drones->scan_proof_of_ownership)->original}}"> <img height="100px" src="{{json_decode($drones->scan_proof_of_ownership)->resized}}" alt=""> </a></td>
                              </tr>
                              <tr>
                                  <td>Foto Bukti Kepemilikan</td>
                                  <td><a href="{{json_decode($drones->proof_of_ownership)->original}}"> <img height="100px" src="{{json_decode($drones->proof_of_ownership)->resized}}" alt=""> </a></td>
                              </tr>
                              <tr>
                                  <td>Manufacturer</td>
                                  <td>{{$drones->manufacturer}}</td>
                              </tr>
                              <tr>
                                  <td>Model</td>
                                  <td>{{$drones->model}}</td>
                              </tr>
                              <tr>
                                  <td>Specific Model</td>
                                  <td>{{$drones->specific_model}}</td>
                              </tr>

                          </tbody>
                      </table>
                      <hr>
                      @if ($drones->approved == 0)
                        <div class="pull-right">
                          <button type="submit" class="btn btn-sm btn-success">Approve</button>
                        </div>
                      @endif

                  </form>
                  @if (Auth::User()->roles_id == 3)
                    <a href="/drones" class="btn btn-sm btn-danger pull-right mr-2">Kembali</a>
                  @else
                    <a href="/approvedrones" class="btn btn-sm btn-danger pull-right mr-2">Kembali</a>
                  @endif

                  </div>
              </div>
          </div>
      </div>
  </div>



  <!-- Add Front menu content -->

  <!-- Signup modal content -->



@endsection
@section('js')
  <!-- Bootstrap fileupload js -->
  <script src="{!! asset('plugins/bootstrap-fileupload/bootstrap-fileupload.js') !!}"></script>
  <!-- Sweet Alert Js  -->
  <script src="{!! asset('plugins/sweet-alert/sweetalert2.min.js') !!}"></script>



@endsection
