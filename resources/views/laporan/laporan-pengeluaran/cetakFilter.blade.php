<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengeluaran</title>
    <link rel="stylesheet" href="css/laporanPengeluaran.css">

</head>
<body>
    <div class="header">
        {{-- <img src="img/test.jpg" alt="Logo Perusahaan" class="logo"> --}}
        <div class="judul">UD. KLAMBI ANYAR</div>
        <div class="judul">Laporan Pengeluaran</div>
        <div class="tanggal">{{ date('d-m-Y', strtotime($tglAwal)) }} s/d {{ date('d-m-Y', strtotime($tglAkhir)) }} </div>
      
        <div style="clear: both;"></div>
        <hr class="garis">
    </div>

    {{-- <h3>Laporan Data Nasabah</h2> --}}
    <p>Tanggal : {{ Jenssegers\Date\Date::now()->format('l, j F Y') }}</p>
    <table class="tabel-neraca">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Jenis Pengeluaran</th>
                <th>Tanggal</th>
                <th>Metode Pembayaran</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cetak as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->master_pengeluaran->nama_atribut }}</td>
                <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                <td>{{ $item->metode_pembayaran }}</td>
                <td>Rp. {{number_format($item->subtotal) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9"><center>Tidak ada data pengeluaran</center></td>
            </tr>
            @endforelse             
        </tbody>
    </table>
</body>
</html>
