@extends('layouts.main')
@section('container')
    
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Transaksi</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

{{-- error and success handling with sweetalert --}}
<div class="swal" data-swal="{{ session('success') }}">
</div>
<div class="error" data-swal="{{ session('pesan') }}">
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        
        <div class="card card-success card-outline">
          <div class="card-header">
            <strong><h4 >Bayar Piutang  </h4></strong>
          </div>
          
          <form action="/piutang/bayar/{{ $data->id }}" method="POST">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label>Jatuh Tempo</label>
                <input readonly name="customer" type="text" class="form-control" value="{{ date('d-m-Y', strtotime($data->tgl_jatuh_tempo )) }}" >
              </div>
              <div class="form-group">
                <label>Jumlah Piutang</label>
                <input readonly name="customer" type="text" class="form-control" value="Rp. {{ number_format($data->jumlah_piutang)}}" >
              </div>
              <div class="form-group">
                <label for="jumlah">Jumlah Bayar</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp. </span>
                    </div>
                    <input name="jumlah_bayar" type="text" class="form-control jumlah" required>
                  </div>
              </div>   
              <div class="form-group">
                <label>Status</label>
                <select name="status" id="status" class="form-control">
                  <option value="pilih">~ Pilih ~</option>
                  <option value="Lunas">Lunas</option>
                  <option value="Belum Lunas">Belum Lunas</option>
                </select>
              </div>    
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input name="tanggal" type="date" class="form-control" id="tgl" required>
              </div>          
              
              <button type="text" class="btn btn-success mt-4">Simpan</button>
            </div>
          </form>
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

{{-- // sweetalert notification --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const swal = $('.swal').data('swal');
  if(swal){
    Swal.fire({
      'title': 'success',
      'text': swal,
      'icon': 'success',
      'showConfirmButton': false,
      'timer': 3500
    })
  }

  const swalError = $('.error').data('swal');
  if(swalError){
    Swal.fire({
      'title': 'Error Input',
      'text': swalError,
      'icon': 'error',
      'showConfirmButton': false,
      'timer': 3500
    })
  }
</script>

<script>
  $.ajaxSetup({
    headers:{
      'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
  })

  $('.card-body').on('click', '.del', function(e){
        var id = $(this).data('id');

        Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan data yang dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/mstr/pemasukan/delete/' + id, 
                        success: function(data) {
                            Swal.fire({
                              title: 'berhasil',
                              text: data.message,
                              icon: 'success'
                            }).then((result) => {
                               window.location.href = '/mstr/pemasukan/all';
                            })
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            });
        });
</script>
{{-- // End sweetalert notification --}}

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
