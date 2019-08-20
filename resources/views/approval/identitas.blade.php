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
                      <h4 class="m-t-0 header-title">Detail Identitas Pengguna</h4>
                      <p class="text-muted font-14 m-b-30">
                          Kamu bisa melihat detail data pengguna, untuk menyetujui data atau menunda untuk mengirimkan pesan agar pengguna memperbaiki datanya.
                      </p>

                      <br>
                      <form action="/approvalidentitas/{{$user->id}}" role="form" method="post">
                      <input type="hidden" name="_method" value="put">
                      {{ csrf_field() }}
                      <div class="row">
                        <div class="col-12">
                          <div class="card-box">
                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="simpleinput">Nama</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" name="" disabled value="{{$user->nama}}">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="simpleinput">Email</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" name="" disabled value="{{$user->email}}">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="simpleinput">Perusahaan</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" name="" disabled value="{{$user->company}}">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="simpleinput">Alamat</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" name="" disabled value="{{$user->address}}">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="simpleinput">Nomor Telepon</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" name="" disabled value="{{$user->phone}}">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="simpleinput">Dokumen Identitas</label>
                              <div class="col-sm-10">
                                @if ($user->dokumen_identitas)
                                  <?php $datatb = json_decode($user->dokumen_identitas)->original; $datatb2 = json_decode($user->dokumen_identitas)->resized; ?>
                                  <a href="{{$datatb}}"><img src="{{$datatb2}}" alt="" height="100px"></a>
                                @endif
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="simpleinput">Dokumen Sertifikasi</label>
                              <div class="col-sm-10">
                                @if ($user->dokumen_sertifikasi)
                                  <?php $datatb3 = json_decode($user->dokumen_sertifikasi)->original; $datatb4 = json_decode($user->dokumen_sertifikasi)->resized; ?>
                                  <a href="{{$datatb3}}"><img src="{{$datatb4}}" alt="" height="100px"></a>
                                @endif
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>
                      <hr>
                      @if ($user->approved != 1)
                        <div class="pull-right">
                          <button name="approval" value="approve" type="submit" class="btn btn-sm btn-success">Approve</button>
                        </div>
                        <div class="pull-right" style="margin-right:10px">
                          <button name="approval" value="disapprove" type="submit" class="btn btn-sm btn-danger">Disapprove</button>
                        </div>
                      @endif
                  </form>
                    <a href="/approveidentitas" class="btn btn-sm btn-secondary pull-right mr-2">Kembali</a>
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
