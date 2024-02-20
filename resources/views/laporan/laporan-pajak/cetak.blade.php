<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pajak</title>
    <link rel="stylesheet" href="css/laporanPajak.css">

</head>
<body>
    <div class="header">
        {{-- <img src="img/test.jpg" alt="Logo Perusahaan" class="logo"> --}}
        <div class="judul">UD. KLAMBI ANYAR</div>
        <div class="judul">Laporan Pajak</div>
        {{-- <div class="subjudul">Laporan Pemasukan</div> --}}
      
        <div style="clear: both;"></div>
        <hr class="garis">
    </div>

    {{-- <h3>Laporan Data Nasabah</h2> --}}
    <p>Tanggal : {{ Jenssegers\Date\Date::now()->format('l, j F Y') }}</p>
    <table class="tabel-neraca">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Pajak 0.5 %</th>
            </tr>
        </thead>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['nama_customer'] }}</td>
                <td>Rp. {{ number_format($item['total_penjualan']) }}</td>
                <td>Rp. {{ number_format($item['pajak']) }}</td>
            </tr>
        @endforeach

            <tr>
                <td colspan="3" style="font-weight: bold;">Total Pajak</td>
                <td style="font-weight: bold;">Rp. {{ number_format($totalPajak) }}</td>
            </tr>
   </table>

   <div class="footer">
    <div class="ttd">
        <p>Denpasar, {{ Jenssegers\Date\Date::now()->format('l, j F Y') }} </p>
        <p>Pengelola,</p><br><br><br>
        <p>{{ $nama }}</p>
    </div>
   </div>
</body>
</html>
