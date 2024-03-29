@extends('layouts.main')
@section('container')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        
        <div class="card card-success card-outline mt-4">
          <div class="card-header">
            <strong><h5 >Laporan Pengeluaran </h5></strong>
          </div>

          <div class="card-body" >
            <h5 style=" margin-top: 0;"><b>Filter Tanggal :</b></h5>

            <form id="filterForm" action="/dataTable/LaporanPemasukan" method="POST" style=" border-bottom: 1px solid #ccc;">
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
            {{-- <div class="tombol" style="margin-bottom: 20px;">
                <button id="filterMax" class="btn btn-primary"> <i class="fas fa-arrow-up"></i></i> Kredit Terbesar</button>
                <button id="filterMin" class="btn btn-primary"><i class="fas  fa-arrow-down"></i> Kredit Terkecil</button>
                <button id="filterJatuhTempoButton" class="btn btn-primary"> <i class="fas fa-calendar-times"></i>Jatuh Tempo</button>
                <button id="filterMacetButton" class="btn btn-primary"><i class="fas fa-calendar-times"></i>Kredit Macet</button>
                <a class="btn btn-info " target="_blank"  id="cetak" href="/laporan-pinjaman/cetak">
                  <i class="fa fa-print"></i> Cetak
                </a>
             </div> --}}
            <table id="laporan-pengeluaran" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Jenis Pengeluaran</th>
                  <th>Tanggal</th>
                  <th>Metode Pembayaran</th>
                  <th>Subtotal</th>
                </tr>
                </thead>
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
            cetakButton.href = '/laporan-pengeluaran/' + tanggalMulai + '/' + tanggalAkhir;
        } else {
            // Jika salah satu atau keduanya kosong, arahkan ke URL tanpa parameter tanggal
            cetakButton.href = '/laporan-pengeluaran/cetak';
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
    $(document).ready(function(){
    var table =  $('#laporan-pengeluaran').DataTable({
            responsive: true, 
            autoWidth: false,
            processing: true,
            serverside: true,
            ajax:{
              url: "{{ url('dataTable/LaporanPengeluaran') }}",
              type: "POST",
              headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
              },
              data: function(d){
                // d._token = "{{ csrf_token() }}";
                d.tanggal_mulai = $('#tgl_mulai').val(); // Mengambil tanggal mulai
                d.tanggal_akhir = $('#tgl_akhir').val(); // Mengambil tanggal akhir
              } 
            },
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'nama',
                name: 'Nama'
            },{
                data: 'tgl',
                name: 'Tanggal'
            },{
                data: 'metode_pembayaran',
                name: 'Metode Pembayaran'
            },{
                data: 'total',
                name: 'Subtotal'
            }]
        });

        $('#filterForm').submit(function (e) {
        e.preventDefault();
        table.ajax.reload();
      });
        
    });
</script>

@endpush
