@extends("layouts.flayout")

@section("title")
  Konfirmasi Nomor dan Sertifikat Drones
@endsection

@section("content")
    <section id="facts" class="wow fadeIn" style="visibility: visible; animation-name: fadeIn; margin-top: -60px; margin-bottom: -60px;">
        <div class="container">
            <header class="section-header">
                <h3>Konfirmasi Nomor Sertifikat Drones</h3>
            </header>

            <center>
              <p>Berikut Data Sertifkat Drones anda yang tercatat di sistem kami :</p>
            </center>

            <table width="100%">
              <tr>
                <td align="right">Status Drones : </td>
                <?php
                    $status = $drones->status;
                    $status_text = '';
                    switch ($status) {
                      case 1:
                        $status_text = 'Aktif';
                        break;
                      case 2:
                        $status_text = 'Tidak Aktif';
                        break;
                      case 3:
                        $status_text = 'Tidak Aktif Sementara';
                        break;
                      case 4:
                        $status_text = 'Sertifikat Di Cabut';
                        break;
                      default:
                        $status_text = '';
                        break;
                    }
                 ?>
                <td align="left"> <b>{{$status_text}}</b> </td>
              </tr>
              @if ($status != 1)
                <tr>
                  <td align="right">Keterangan : </td>
                  <td align="left"> {{$drones->alasan_pk}} </td>
                </tr>
              @endif
              <tr>
                <td align="right">Model Pesawat Tanpa Awak : </td>
                <td align="left">{{$drones->model}}</td>
              </tr>
              <tr>
                <td align="right">Nama Akun Pemegang : </td>
                <td align="left">{{$drones->nama}}</td>
              </tr>
              <tr>
                <td align="right">Email Akun Pemegang : </td>
                <td align="left">{{$drones->email}}</td>
              </tr>

              <tr>
                <td align="right">Nomor Sertifikat : </td>
                <td align="left">{{$drones->nomor_drone}}</td>
              </tr>
              <tr>
                <td align="right">Sertifikat : </td>
                <td align="left"> <a href="{{$drones->sertifikasi_drone}}">Download</a> </td>
              </tr>
              <tr>
                <td align="right">Disahkan : </td>
                <td align="left">{{ Carbon\Carbon::parse($drones->csr)->diffForHumans() }}</td>
              </tr>
            </table>

            <div class="facts-img">
                <img src="img/facts-img.png" alt="" class="img-fluid">
            </div>
        </div>
    </section>
@endsection
