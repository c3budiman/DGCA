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
                      <h4 class="m-t-0 header-title">Approval Menu Management</h4>
                      <p class="text-muted font-14 m-b-30">
                          You can add, edit and delete menu for frontend in here.
                      </p>

                      <br>
                      <form action="/approvalidentitas/{{$user->id}}" role="form" method="post">
                      <input type="hidden" name="_method" value="put">
                      {{ csrf_field() }}
                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <tbody>
                              <tr>
                                  <td>Nama</td>
                                  <td>{{$user->nama}}</td>
                              </tr>
                              <tr>
                                  <td>Email</td>
                                  <td>{{$user->email}}</td>
                              </tr>

                          </tbody>
                      </table>
                      <hr>
                      <div class="pull-right">
                      <button type="submit" class="btn btn-sm btn-success">Approve</button>
                    </div>
                  </form>
                  <a href="/approveidentitas" class="btn btn-sm btn-danger pull-right mr-2">Kembali</a>
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
