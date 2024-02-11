@extends('layouts.main')
@section('container')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        
        <div class="card card-success card-outline mt-4">
          <div class="card-header">
            <strong><h5 >Detail Penjualan Jasa Jarit  </h5></strong>
          </div>
        
          <div class="card-header" style=" border-bottom: none;">
            <p><strong>Kode Penjualan : {{ $data->kode_penjualan }} </strong></p>
            <p><strong>Total Penjualan : Rp. {{ number_format($data->jmlh_dibayar) }}</strong></p>
            <p><strong>Tanggal Penjualan : {{ date('d-m-Y', strtotime( $data->tanggal )) }} </strong></p>
          </div>

          <div class="card-body">
            <h4>Daftar Penjualan Jasa Jarit :</h4>
              <table class="table ">
                  <thead>
                      <tr>
                          <th>Jenis Jaritan</th>
                          <th>Jumlah Barang</th>
                          <th>Harga Satuan</th>
                          <th>Subtotal</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($penjualan as $item)
                          <tr>
                              <td>{{ $item->master_jaritan->jenis_jaritan }}</td>
                              <td>{{ $item->jumlah_barang }}</td>
                              <td>Rp.{{ number_format($item->harga_satuan) }}</td>
                              <td>Rp.{{ number_format($item->subtotal) }}</td>
                          </tr>
                      @endforeach
                  </tbody>
                  
              </table>
          </div>

          <div class="card-footer">
            <a href="" class="btn btn-success"> </a>
          </div>
          
         
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
      $('#penjualan').DataTable({
            "responsive": true, 
            "autoWidth": false,
            "processing": true,
            "serverside": true,
            "ajax": "{{ url('/dataTable/penjualan-jasa') }}",
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'nama',
                name: 'Nama'
            },{
                data: 'kode_penjualan',
                name: 'Kode'
            },{
                data: 'tgl',
                name: 'Tanggal'
            },{
                data: 'metode_pembayaran',
                name: 'Metode Pembayaran'
            },{
                data: 'dibayar',
                name: 'Pembayaran Cash'
            },{
                data: 'bayarAwal',
                name: 'Pembayaran Credit'
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
