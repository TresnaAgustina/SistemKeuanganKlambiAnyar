@extends('layouts.main')
@section('container')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        
        <div class="card card-success card-outline mt-4">
          <div class="card-header">
            <strong><h5 >Laporan Keuntungan </h5></strong>
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
                  <th>Data</th>
                  <th>Total</th>
                  <th>Subtotal Keuntungan</th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Pemasukan</td>
                    <td>Rp. 0 </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Pengeluaran</td>
                    <td>Rp. 0 </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td style="font-weight: bold;">Keuntungan</td>
                    <td></td>
                    <td style="font-weight: bold;">Rp. 0 </td>
                  </tr>
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

    cetakButton.addEventListener('click', function(event) {
        var tanggalMulai = tanggalMulaiInput.value;
        var tanggalAkhir = tanggalAkhirInput.value;

        if (tanggalMulai && tanggalAkhir) {
            // Jika kedua input tanggal diisi, arahkan ke URL dengan tanggal
            cetakButton.href = '/laporan-keuntungan/' + tanggalMulai + '/' + tanggalAkhir;
        } else {
            // Jika salah satu atau keduanya kosong, arahkan ke URL tanpa parameter tanggal
            cetakButton.href = '/laporan-keuntungan/cetak';
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
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
}
    $('#filterForm').submit(function(event) {
        event.preventDefault();

        var tanggalMulai = $('#tgl_mulai').val();
        var tanggalAkhir = $('#tgl_akhir').val();

        $.ajax({
            url: '/laporan-keuntungan/test',
            type: 'GET',
            data: {
                tglawal: tanggalMulai,
                tglakhir: tanggalAkhir
            },
            success: function(response) {
                // Memasukkan data ke dalam tabel HTML
                $('#laporan-pemasukan tbody tr:nth-child(1) td:nth-child(2)').text(formatNumber(response.pemasukan));
                $('#laporan-pemasukan tbody tr:nth-child(2) td:nth-child(2)').text(formatNumber(response.pengeluaran));
                $('#laporan-pemasukan tbody tr:nth-child(3) td:nth-child(3)').text(formatNumber(response.keuntungan));
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});

</script>
@endpush
