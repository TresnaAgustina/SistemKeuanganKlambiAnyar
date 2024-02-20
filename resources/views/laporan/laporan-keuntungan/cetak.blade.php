<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuntungan</title>
    <link rel="stylesheet" href="css/laporanPemasukan.css">

</head>
<body>
    <div class="header">
        {{-- <img src="img/test.jpg" alt="Logo Perusahaan" class="logo"> --}}
        <div class="judul">UD. KLAMBI ANYAR</div>
        <div class="judul">Laporan Keuntungan</div>
        {{-- <div class="subjudul">Laporan Pemasukan</div> --}}
      
        <div style="clear: both;"></div>
        <hr class="garis">
    </div>

    {{-- <h3>Laporan Data Nasabah</h2> --}}
    <p>Tanggal : {{ Jenssegers\Date\Date::now()->format('l, j F Y') }}</p>
    <table class="tabel-neraca">
        <thead>
            <tr>
                <th>Data</th>
                <th>Nama Pemasukan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalRows = count($pemasukan) + 1; // Hitung jumlah baris yang akan dibuat
            @endphp
            <tr>
                <th rowspan="{{ $totalRows }}">Pemasukan</th>
                <td ></td>
                <td></td>
            </tr>
                @foreach ($pemasukan as $item)
                    <tr>
                        <td>{{ $item->master_pemasukan->nama_atribut }}</td>
                        <td>Rp. {{ number_format($item->total)}}</td>
                    </tr>
                @endforeach
        </tbody>
        <tbody>
            <tr>
                <td style="font-weight: bold;" colspan="2">Total Pemasukan</td>
                <td style="font-weight: bold;">Rp. {{ number_format($totPemasukan)}}</td>
            </tr>
        </tbody>
       
        <thead>
            <tr>
                <th>Data</th>
                <th>Nama Pengeluaran </th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalRows = count($pengeluaran) + 1; // Hitung jumlah baris yang akan dibuat
            @endphp
            <tr>
                <th rowspan="{{ $totalRows }}">Pengeluaran</th>
                <td ></td>
                <td></td>
            </tr>
                @foreach ($pengeluaran as $item)
                    <tr>
                        <td>{{ $item->master_pengeluaran->nama_atribut }}</td>
                        <td>Rp. {{ number_format($item->subtotal)}}</td>
                    </tr>
                @endforeach
        </tbody>
        <tbody>
            <tr>
                <td style="font-weight: bold;" colspan="2">Total Pengeluaran</td>
                <td style="font-weight: bold;">Rp. {{ number_format($totPengeluaran)}}</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td style="font-weight: bold;" colspan="2">Keuntungan</td>
                <td style="font-weight: bold;">Rp. {{ number_format($keuntungan)}}</td>
            </tr>
        </tbody>
       
    </table>
</body>
</html>
