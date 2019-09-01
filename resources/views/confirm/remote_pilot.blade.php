@extends("layouts.flayout")

@section("title")
  Konfirmasi Nomor dan Sertifikat Remote Pilot
@endsection

@section("content")
    <section id="facts" class="wow fadeIn" style="visibility: visible; animation-name: fadeIn; margin-top: -60px; margin-bottom: -60px;">
        <div class="container">
            <header class="section-header">
                <h3>Konfirmasi Nomor Sertifikat Remote Pilot</h3>
            </header>

            <center>
              <p>Berikut Data Sertifkat Remote Pilot anda yang tercatat di sistem kami :</p>
            </center>

            <table width="100%">
              <tr>
                <td align="right">Status Remote Pilot : </td>
                <?php
                    $status = $remote_pilot->status;
                    $status_text = '';
                    switch ($status) {
                      case 1:
                        $status_text = 'Aktif';
                        break;
                      case 2:
                        $status_text = 'Tidak Aktif';
                        break;
                      case 3:
                        $status_text = 'Sertifikat Di Cabut';
                        break;
                      default:
                        $status_text = '';
                        break;
                    }
                 ?>
                <td align="left">{{$status_text}}</td>
              </tr>
              <tr>
                <td align="right">Nama Remote Pilot : </td>
                <td align="left">{{$remote_pilot->nama}}</td>
              </tr>
              <tr>
                <td align="right">Registered Email : </td>
                <td align="left">{{$remote_pilot->email}}</td>
              </tr>
              <tr>
                <td align="right">Nomor Sertifikat : </td>
                <td align="left">{{$remote_pilot->nomor_pilot}}</td>
              </tr>
              <tr>
                <td align="right">Sertifikat : </td>
                <td align="left"> <a href="{{$remote_pilot->sertifikasi_pilot}}">Download</a> </td>
              </tr>
              <tr>
                <td align="right">Disahkan : </td>
                <td align="left">{{ Carbon\Carbon::parse($remote_pilot->csr)->diffForHumans() }}</td>
              </tr>
            </table>

            <div class="facts-img">
                <img src="img/facts-img.png" alt="" class="img-fluid">
            </div>
        </div>
    </section>
@endsection
