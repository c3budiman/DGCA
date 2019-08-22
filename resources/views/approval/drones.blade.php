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
                                <td bgcolor="#c0d04c" align="center" colspan="2">Identitas</td>
                              </tr>
                              <tr>
                                  <td>Pengusul</td>
                                  @if (Auth::User()->roles_id == 3)
                                    <td> <a href="{{url('/').'/identitas/'}}">{{DB::table('users')->where('id','=',$drones->user_id)->first()->nama}}</a> </td>
                                  @else
                                    <td> <a href="{{url('/').'/detail/identitas/'.$drones->user_id}}">{{DB::table('users')->where('id','=',$drones->user_id)->first()->nama}}</a> </td>
                                  @endif
                              </tr>

                              <tr>
                                <td bgcolor="#c0d04c" align="center" colspan="2">Dokumen Registrasi (DGCA Registration Documents)</td>
                              </tr>
                              <tr>
                                  <td>Foto Drone</td>
                                  @if ($drones->pic_of_drones)
                                    <td><a href="{{json_decode($drones->pic_of_drones)->original}}"> <img height="100px" src="{{json_decode($drones->pic_of_drones)->resized}}" alt=""> </a></td>
                                  @else
                                    <td></td>
                                  @endif
                              </tr>
                              <tr>
                                  <td>Foto Serial Nomor Drone</td>
                                  @if ($drones->pic_of_drones_with_sn)
                                    <td><a href="{{json_decode($drones->pic_of_drones_with_sn)->original}}"> <img height="100px" src="{{json_decode($drones->pic_of_drones_with_sn)->resized}}" alt=""> </a></td>
                                  @else
                                    <td></td>
                                  @endif
                              </tr>
                              <tr>
                                  <td>Foto Bukti Penguasaan Pesawat Udara Tanpa Awak</td>
                                  @if ($drones->scan_proof_of_ownership)
                                    <td><a href="{{json_decode($drones->scan_proof_of_ownership)->original}}"> <img height="100px" src="{{json_decode($drones->scan_proof_of_ownership)->resized}}" alt=""> </a></td>
                                  @else
                                    <td></td>
                                  @endif
                              </tr>
                              <tr>
                                  <td>Foto Bukti Kepemilikan</td>
                                  @if ($drones->scan_proof_of_ownership)
                                    <td><a href="{{json_decode($drones->proof_of_ownership)->original}}"> <img height="100px" src="{{json_decode($drones->proof_of_ownership)->resized}}" alt=""> </a></td>
                                  @else
                                    <td></td>
                                  @endif
                              </tr>
                              <tr>
                                <td bgcolor="#c0d04c" align="center" colspan="2">Pesawat Udara Tanpa Awak (Unmanned Aircraft System)</td>
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
                              <tr>
                                  <td>Nama Pembuat</td>
                                  <td>{{ $drones->manufacturer}}</td>
                              </tr>

                              <tr>
                                  <td>Model</td>
                                  <td>{{ $drones->model}}</td>
                              </tr>

                              <tr>
                                  <td>Nama Model Khusus (Specific Model Name)</td>
                                  <td>{{ $drones->specific_model}}</td>
                              </tr>

                              <tr>
                                  <td>Tahun Pembuatan (Years Of Manufacture)</td>
                                  <td>{{ $drones->model_year}}</td>
                              </tr>

                              <tr>
                                  <td>Keadaan (Condition)</td>
                                  <td>{{ $drones->condition}}</td>
                              </tr>

                              <tr>
                                  <td>Berat Maksimum Tinggal Landas (Maximum Take-Off Weight)</td>
                                  <td>{{ $drones->max_weight_take_off}}</td>
                              </tr>

                              <tr>
                                <td bgcolor="#c0d04c" align="center" colspan="2">Kepemilikan Pesawat Udara Tanpa Awak (UAS Ownership)</td>
                              </tr>

                              <tr>
                                  <td>Dasar Kepemilikan (Term of Ownership)</td>
                                  <td>{{ $drones->termofowenership }}</td>
                              </tr>

                              <tr>
                                  <td>Nama Pemilik (Owner)</td>
                                  <td>{{ $drones->owner }}</td>
                              </tr>

                              <tr>
                                  <td>Alamat Drones (Drone Address)</td>
                                  <td>{{ $drones->address}}</td>
                              </tr>

                              <tr>
                                  <td>Bukti Kepemilikan (Evidence of ownership)</td>
                                  <td>{{ $drones->evidenceofowenership}}</td>
                              </tr>

                              <tr>
                                  <td>Tanggal Kepemilikan (Date)</td>
                                  <td>{{ $drones->dateownership}}</td>
                              </tr>

                              <tr>
                                <td bgcolor="#c0d04c" align="center" colspan="2">Dasar Penguasaan Pesawat Udara Tanpa Awak (UAS Term Of Possession)</td>
                              </tr>

                              <tr>
                                  <td>Dasar Penguasaan (Term Of Possession)</td>
                                  <td>{{ $drones->termofposession}}</td>
                              </tr>

                              <tr>
                                  <td>Referensi</td>
                                  <td>{{ $drones->reference}}</td>
                              </tr>

                              <tr>
                                <td bgcolor="#c0d04c" align="center" colspan="2">Pemberi Sewa (Lessor)</td>
                              </tr>

                              <tr>
                                  <td>Nama</td>
                                  <td>{{ $drones->namapemberisewa}}</td>
                              </tr>

                              <tr>
                                  <td>Alamat</td>
                                  <td>{{ $drones->alamatpemberisewa}}</td>
                              </tr>

                              <tr>
                                  <td>Email</td>
                                  <td>{{ $drones->emailpemberisewa}}</td>
                              </tr>

                              <tr>
                                  <td>Nomor Telepon</td>
                                  <td>{{ $drones->nomorteleponpemberisewa}}</td>
                              </tr>

                          </tbody>
                      </table>
                      <hr>
                      @if ($drones->approved != 1)
                        <div class="pull-right">
                          <button name="approval" value="approve" type="submit" class="btn btn-sm btn-success">Approve</button>
                        </div>
                        <div class="pull-right" style="margin-right:10px">
                          <button name="approval" value="disapprove" type="submit" class="btn btn-sm btn-danger">Disapprove</button>
                        </div>
                      @endif

                  </form>
                  @if (Auth::User()->roles_id == 3)
                    <a href="/drones" class="btn btn-sm btn-secondary pull-right mr-2">Kembali</a>
                  @else
                    <a href="/approvedrones" class="btn btn-sm btn-secondary pull-right mr-2">Kembali</a>
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
