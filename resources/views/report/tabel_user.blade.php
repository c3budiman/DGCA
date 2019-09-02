<table>
  <tr>
    <td>Nama</td>
    <td>Email</td>
    <td>Status</td>
    <td>Perusahaan</td>
    <td>Status Keanggotaan Perusahaan</td>
    <td>Alamat</td>
    <td>Nomor KTP</td>
    <td>Nomor HP</td>
    <td>Tanggal Pendaftaran</td>
  </tr>

  @foreach (DB::table('users')->where('roles_id','3')->get() as $user)
    <tr>
      <td>{{$user->nama}}</td>
      <td>{{$user->email}}</td>

      @if ($user->active == 1)
        @if ($user->approved == 1)
          <td>Remote Pilot Terdaftar</td>
        @else
          <td>Remote Pilot Belum Terdaftar</td>
        @endif
      @else
        <td>Belum Verifikasi Email</td>
      @endif
      <td>{{ DB::table('perusahaan')->where('id',$user->company)->first()->nama_perusahaan }}</td>
      @if ($user->approved_company)
        <td>Terverifikasi</td>
      @else
        <td>Belum Terverifikasi</td>
      @endif

      <?php
      $address = 'N/A';
      if ($user->address) {
        $tes = explode('\,',$user->address);
        foreach ($tes as $t) {
          $address .= $t;
        }
      }
       ?>
      <td>{{$address}}</td>

      @if ($user->ktp)
        <td>'{{$user->ktp}}</td>
      @else
        <td>N/A</td>
      @endif

      @if ($user->phone)
        <td>'{{$user->phone}}</td>
      @else
        <td>N/A</td>
      @endif
      <td>{{$user->created_at}}</td>
    </tr>
  @endforeach
</table>
