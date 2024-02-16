<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemasukan</title>
    <link rel="stylesheet" href="css/laporanPemasukan.css">

</head>
<body>
    <div class="header">
        {{-- <img src="img/test.jpg" alt="Logo Perusahaan" class="logo"> --}}
        <div class="judul">UD. KLAMBI ANYAR</div>
        <div class="judul">Laporan Pemasukan</div>
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
                <th>Jenis Pemasukan</th>
                <th>Tanggal</th>
                <th>Metode Pembayaran</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cetak as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->master_pemasukan->nama_atribut }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                    <td>{{ $item->metode_pembayaran }}</td>
                    <td>Rp. {{number_format($item->total) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
