<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nasabah</title>
    <link rel="stylesheet" href="css/laporan.css">

</head>
<body>
    <div class="header">
        {{-- <img src="img/test.jpg" alt="Logo Perusahaan" class="logo"> --}}
        <div class="judul">KSP. "DANA SUMA YUKTI"</div>
        <div class="subjudul">BADAN HUKUM NO. : 008544/BH/M.KUKM.2.V/2018</div>
        <div class="subjudul">DESA TOHPATI, KECAMATAN BANJARANGKAN</div>
        <div class="subjudul">KABUPATEN KLUNGKUNG, BALI</div>
        <div class="hp">No Hp : 081 936 135 320</div>
        <div style="clear: both;"></div>
        <hr class="garis">
    </div>

    <h3>Laporan Data Nasabah</h2>
    {{-- <p>Tanggal : {{ \Jenssegers\Date\Date::now()->format('l, j F Y') }}</p> --}}
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
