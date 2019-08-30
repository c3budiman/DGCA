<?php
  $logo = DB::table('setting_situses')->where('id','=','1')->first()->logo;
?>
@extends('layouts.dlayout')

@section('title')
  Detail Perusahaan
@endsection

@section('css')
  <script src="{{ asset('js/app2.js') }}"></script>
@endsection

@section('content')
  <div class="content">
      <div class="container-fluid">
          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h4 class="m-t-0 header-title">Detail Perusahaan</h4>
                      <br>
                      <form action="/approval/perusahaan/{{$perusahaan->id}}" role="form" method="post">
                      <input type="hidden" name="_method" value="put">
                      {{ csrf_field() }}
                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <tbody>
                              <tr>
                                <td bgcolor="#c0d04c" align="center" colspan="2">Dokumen Perusahaan (Registration Documents)</td>
                              </tr>
                              <tr>
                                  <td>Scan SIUP</td>
                                  @if ($perusahaan->dokumen_siup)
                                    <td><a href="{{json_decode($perusahaan->dokumen_siup)->original}}"> <img height="100px" src="{{json_decode($perusahaan->dokumen_siup)->resized}}" alt=""> </a></td>
                                  @else
                                    <td></td>
                                  @endif
                              </tr>
                              <tr>
                                  <td>Scan KTP Penanggung</td>
                                  @if ($perusahaan->dokumen_ktp_penanggung)
                                    <td><a href="{{json_decode($perusahaan->dokumen_ktp_penanggung)->original}}"> <img height="100px" src="{{json_decode($perusahaan->dokumen_ktp_penanggung)->resized}}" alt=""> </a></td>
                                  @else
                                    <td></td>
                                  @endif
                              </tr>
                              <tr>
                                  <td>Scan NPWP</td>
                                  @if ($perusahaan->dokumen_npwp)
                                    <td><a href="{{json_decode($perusahaan->dokumen_npwp)->original}}"> <img height="100px" src="{{json_decode($perusahaan->dokumen_npwp)->resized}}" alt=""> </a></td>
                                  @else
                                    <td></td>
                                  @endif
                              </tr>
                              <tr>
                                <td bgcolor="#c0d04c" align="center" colspan="2">Identitas Perusahaan</td>
                              </tr>
                              <tr>
                                  <td>Nama Perusahaan</td>
                                  <td>{{$perusahaan->nama_perusahaan}}</td>
                              </tr>
                              <tr>
                                  <td>Alamat Perusahaan</td>
                                  <td>{{$perusahaan->alamat_perusahaan}}</td>
                              </tr>
                              <tr>
                                  <td>Nomor Telepon</td>
                                  <td>{{$perusahaan->nomor_telepon}}</td>
                              </tr>
                              <tr>
                                  <td>Nomor SIUP</td>
                                  <td>{{ $perusahaan->nomor_siup}}</td>
                              </tr>

                              <tr>
                                  <td>Nomor NPWP</td>
                                  <td>{{ $perusahaan->nomor_npwp}}</td>
                              </tr>

                              <tr>
                                  <td>Nomor KTP Penanggung</td>
                                  <td>{{ $perusahaan->nomor_ktp_penanggung}}</td>
                              </tr>

                          </tbody>
                      </table>
                      <hr>
                      @if ($perusahaan->approved != 1)
                        <div class="pull-right">
                          <button name="approval" value="approve" type="submit" class="btn btn-sm btn-success">Approve</button>
                        </div>
                        <div class="pull-right" style="margin-right:10px">
                          <button name="approval" value="disapprove" type="submit" class="btn btn-sm btn-danger">Disapprove</button>
                        </div>
                      @endif
                  </form>
                  @if (Auth::User()->roles_id == 2)
                    <a href="/approval/company" class="btn btn-sm btn-secondary pull-right mr-2">Kembali</a>
                  @else
                    <a href="/dashboard" class="btn btn-sm btn-secondary pull-right mr-2">Kembali</a>
                  @endif

                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection

@section('js')
  <!-- Bootstrap fileupload js -->
  <script src="{!! asset('plugins/bootstrap-fileupload/bootstrap-fileupload.js') !!}"></script>
  <!-- Sweet Alert Js  -->
  <script src="{!! asset('plugins/sweet-alert/sweetalert2.min.js') !!}"></script>
@endsection
