@extends('layouts.main')
@section('container')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        
        <div class="card card-success card-outline mt-4">
          <div class="card-header">
            <strong><h5 >Laporan Pajak </h5></strong>
          </div>

          <div class="card-body" >
            <h5 style=" margin-top: 0;"><b>Filter Tanggal :</b></h5>

            <form id="filterForm" action="" method="" style=" border-bottom: 1px solid #ccc;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nip">Tanggal  Mulai</label>
                            <input name="nip" type="date" class="form-control" id="tgl_mulai" >
                        </div>  
                    </div>
                        <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nip">Tanggal Akhir </label>
                            <input name="nip" type="date" class="form-control" id="tgl_akhir" >
                        </div> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="nama">Input Nama Tanda Tangan</label>
                    <input name="nama" type="text" class="form-control" id="nama" >
                </div>
              
                <div class="card-header">
                    <a class="btn btn-info float-right" target="_blank"  id="cetakButton" href="#">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                     
  
                      <button type="submit" name="submit" style="margin-right: 10px;" class="btn btn-warning float-right">
                        <i class="fas fa-filter"></i> Filter
                      </button>
                    
                      <button type="button" onclick="resetTanggal()" class="btn btn-success float-right" style="margin-right: 10px;">
                        <i class="fas fa-undo-alt"></i> Reset Tanggal
                      </button>
                </div>
            </form>
          </div>
          <div class="card-body">
            <table id="laporan-pemasukan" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Jumlah</th>
                  <th>Pajak 0.5%</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                  <tr>
                      <td ></td>
                      <td class="nama"></td>
                      <td class="penjualan"></td>
                      <td class="pajak"></td>
                  </tr>
                  @endforeach
              </tbody>
          
              </table>
         </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- ./row -->

  </div><!-- /.container-fluid -->

</section>



@endsection

@push('js')

<script>
  $(document).ready(function() {
    var cetakButton = document.getElementById('cetakButton');
    var tanggalMulaiInput = document.getElementById('tgl_mulai');
    var tanggalAkhirInput = document.getElementById('tgl_akhir');
    var namaInput = document.getElementById('nama'); // Ambil elemen input nama

    cetakButton.addEventListener('click', function(event) {
        var tanggalMulai = tanggalMulaiInput.value;
        var tanggalAkhir = tanggalAkhirInput.value;
        var nama = namaInput.value; // Ambil nilai input nama


        if (tanggalMulai && tanggalAkhir) {
            // Jika kedua input tanggal diisi, arahkan ke URL dengan tanggal
            // cetakButton.href = '/laporan-pajak/' + tanggalMulai + '/' + tanggalAkhir;
            cetakButton.href = '/laporan-pajak/' + tanggalMulai + '/' + tanggalAkhir + '?nama=' + encodeURIComponent(nama);
        } else {
            // Jika salah satu atau keduanya kosong, arahkan ke URL tanpa parameter tanggal
            // cetakButton.href = '/laporan-pajak/cetak';
            cetakButton.href = '/laporan-pajak/cetak?nama=' + encodeURIComponent(nama);
        }
    });
});


  function resetTanggal() {
      // Mengambil elemen input tanggal_mulai dan tanggal_akhir
      var tanggalMulaiInput = document.getElementById('tgl_mulai');
      var tanggalAkhirInput = document.getElementById('tgl_akhir');

      // Mereset nilai input tanggal_mulai dan tanggal_akhir menjadi null
      tanggalMulaiInput.value = null;
      tanggalAkhirInput.value = null;
  }

</script>


{{-- //Datatble Config --}}

<script>
  $(document).ready(function() {
    function formatNumber(number) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number);
}

      function updateTable(data) {
          var html = '';

          // Bangun kembali isi tabel dengan data yang diterima
          data.forEach(function(item, index) {
              html += '<tr>';
              html += '<td>' + (index + 1) + '</td>';
              html += '<td class="nama">' + item.nama_customer + '</td>';
              html += '<td class="penjualan">' + formatNumber(item.total_penjualan) + '</td>';
              html += '<td class="pajak">' + formatNumber(item.pajak) + '</td>';
              html += '</tr>';
          });

          // Perbarui konten tabel dengan HTML baru
          $('#laporan-pemasukan tbody').html(html);
      }

      $('#filterForm').submit(function(event) {
          event.preventDefault();

          var tanggalMulai = $('#tgl_mulai').val();
          var tanggalAkhir = $('#tgl_akhir').val();

          $.ajax({
              url: '/laporan-pajak/config',
              type: 'GET',
              data: {
                  tglawal: tanggalMulai,
                  tglakhir: tanggalAkhir
              },
              success: function(response) {
                  // Memperbarui konten tabel dengan respons yang diterima
                  updateTable(response);
              },
              error: function(xhr, status, error) {
                  console.error(error);
              }
          });
      });
  });
</script>

@endpush
