@extends('layouts.main')
@section('container')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        
        <div class="card card-success card-outline mt-4">
          <div class="card-header">
            <strong><h5 >Laporan Pemasukan </h5></strong>
          </div>

          <div class="card-body" >
            <h5 style=" margin-top: 0;"><b>Filter Tanggal :</b></h5>

            <form action="" style=" border-bottom: 1px solid #ccc;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nip">Tanggal Awal</label>
                            <input name="nip" type="date" class="form-control" id="tgl_awal" >
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
            <table id="laporan-pemasukan" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Jenis Pemasukan</th>
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


{{-- //Datatble Config --}}
<script>
    $(document).ready(function(){
      $('#laporan-pemasukan').DataTable({
            "responsive": true, 
            "autoWidth": false,
            "processing": true,
            "serverside": true,
            "ajax": "{{ url('/dataTable/LaporanPemasukan') }}",
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
    });
</script>

<script>
  $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
  });
  
    $('body').on('click', '.edit', function(e){
        var id = $(this).data('id');
        $.ajax({
          url:'/mstr/pemasukan/update/' + id,
          success:function(response){
            $('#test').modal('show');
            $('#nama').val(response.result.nama_atribut);
          }
        });
    });
  
  // hapus data pada form ketika di tutup
    $(document).ready(function(){
        $('#md-pemasukan').on('hidden.bs.modal', function(){
            $(this).find('#jenis').val(''); // Mengosongkan nilai input di dalam modal
            $(this).find('#total').val(''); // Mengosongkan nilai input di dalam modal
        });
    });

    $(document).ready(function() {
      // Mendapatkan tanggal sekarang dalam format YYYY-MM-DD
      var tanggalSekarang = new Date().toISOString().split('T')[0];
      $('#tgl').val(tanggalSekarang);
    });

    //set fotmat angka jumlah
    function formatRupiah(angka) {
      var numberString = angka.toString();
      var splitNumber = numberString.split('.');
      var sisa = splitNumber[0].length % 3;
      var rupiah = splitNumber[0].substr(0, sisa);
      var ribuan = splitNumber[0].substr(sisa).match(/\d{3}/g);

      if (ribuan) {
          var separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }

      if (splitNumber[1] != undefined) {
          rupiah += ',' + splitNumber[1];
      }

      return rupiah;
    }

    $('.jumlah').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });


  </script>


@endpush
