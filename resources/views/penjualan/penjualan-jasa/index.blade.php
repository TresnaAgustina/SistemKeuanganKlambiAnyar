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
            
            <form action="/aktivitas/create" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input name="tanggal" type="date" class="form-control" id="tgl" required>
                </div>          
                <div class="form-group">
                  <label>Pelanggan</label>
                  <select class="form-control" name='pelanggan' id="pelanggan">
                    <option value="">~ Pilih ~</option>
                    @foreach ($pelanggan as $item)
                      @if (old('jenis_pemasukan') == $item->id)
                        <option value="{{ $item->id }}" selected>{{ $item->nama_customer }}</option>
                      @else
                       <option value="{{ $item->id }}">{{ $item->nama_customer }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Metode Pembayaran</label>
                  <select class="form-control" name='pembayaran' id="pembayaran">
                    <option value="Pilih">~ Pilih ~</option>                 
                    <option value="Cash">Cash</option>                 
                    <option value="Credit">Credit</option>                 
                  </select>
                </div> 
                <div class="card dibayar">
                  <div class="card-body">
                    <div class="form-group ">
                      <label for="total">Pembayaran Awal</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Rp. </span>
                          </div>
                          <input name="total" type="text" class="form-control" id="" required>
                        </div>
                    </div> 
                  </div>
                </div>  
                <div class="form-group bayar">
                  <label for="total">Dibayar</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp. </span>
                      </div>
                      <input name="total" type="text" class="form-control" id="" required>
                    </div>
                </div> 
                <div class="form-group ">
                  <label for="bukti">Bukti Pembayaran</label> <br>
                  <input type="file" id="bukti" name="bukti">
                </div>
              </div>

              <div class="card-header">
                <strong><h4 >Tambah Barang </h4></strong>
              </div>
              <div class="card-body">
                <table id="barang" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah Barang</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th><a href="javascript:void(0)" class="btn btn-success btn-sm addRow"> <i class="fas fa-plus"></i> </a></th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <select class="form-control barangSelect" name="barang[0][id_mstr_barang]">
                        <option value="">~ Pilih ~</option>
                        @foreach ($barang as $item)
                          @if (old('barang[0][id_mstr_barang]') == $item->id)
                            <option data-id={{ $item->id }} value="{{ $item->id }}" selected>{{ $item->nama_barang }}</option>
                          @else
                           <option data-id={{ $item->id }} value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                          @endif
                        @endforeach
                      </select>
                      </td>
                      <td><input type="number" name="barang[0][jumlah_barang]" class="form-control jumlah-barang"></td>
                      <td><input type="text" name="barang[0][harga_satuan]" class="form-control hargaSatuanInput"></td>
                      <td><input type="text" name="barang[0][subtotal]" class="form-control subtotal"></td>
                    </tr>
                  </tbody>
                </table>
                <button type="submit" class="btn btn-success mt-4">Simpan</button>
              </div>
            </form>

          
            {{-- <div class="card-body">
              
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#md-pemasukan">
                <i class="fas fa-plus"></i>
                Tambah Data
              </button>
             
            </div> --}}
            <!-- /.card -->

            {{-- <div class="card-body">
                <table id="pemasukan" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Jenis Pemasukan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                </table>
              </div> --}}
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- ./row -->

    </div><!-- /.container-fluid -->

  </section>

@endsection

@push('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $('thead').on('click', '.addRow', function(){
        var tr = `<tr> 
          <td>
            <select class="form-control barangSelect" name="barang[0][id_mstr_barang]">
              <option value="">~ Pilih ~</option>
              @foreach ($barang as $item)
                @if (old('barang[0][id_mstr_barang]') == $item->id)
                  <option data-id={{ $item->id }} value="{{ $item->id }}" selected>{{ $item->nama_barang }}</option>
                @else
                  <option data-id={{ $item->id }} value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                @endif
              @endforeach
            </select>
          </td>
          <td><input type="number" name="barang[0][jumlah_barang]" class="form-control jumlah-barang"></td>
          <td><input type="text" name="barang[0][harga_satuan]" class="form-control hargaSatuanInput"></td>
          <td><input type="text" name="barang[0][subtotal]" class="form-control subtotal"></td>
          <td><a href="javascript:void(0)" class="btn btn-danger btn-sm deleteRow">
              <i class="fas fa-minus"></i></a>
          </td>
          </tr>`;
        $('tbody').append(tr);
    });

    // Menggunakan event delegation untuk menghapus baris
    $('tbody').on('click', '.deleteRow', function(){
        $(this).parent().parent().remove();   
    });
  </script>

<script>
  $(document).ready(function() {
    // Event handler untuk perubahan pada elemen dengan kelas .barangSelect
    $(document).on('change', '.barangSelect', function() {
        var selectedOption = $(this).val();
        var hargaSatuanInput = $(this).closest('tr').find('.hargaSatuanInput');

        if (selectedOption !== '') {                        
            $.ajax({
                url: '/penjualan-jasa/update/' + selectedOption, 
                method: 'GET', 
                success: function(response) {
                    hargaSatuanInput.val(response.result.harga_jual);
                    formatRupiah(hargaSatuanInput);          
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            hargaSatuanInput.val('');
        }
    });

    // Event handler untuk perubahan pada elemen dengan kelas .hargaSatuanInput dan .jumlah-barang
    $(document).on('input', '.hargaSatuanInput, .jumlah-barang', function() {
        var hargaSatuan = parseFloat($(this).closest('tr').find('.hargaSatuanInput').val()) || 0;
        var jumlahBarang = parseFloat($(this).closest('tr').find('.jumlah-barang').val()) || 0;
        var subtotalInput = $(this).closest('tr').find('.subtotal');

        var subtotal = hargaSatuan * jumlahBarang;
        subtotalInput.val(subtotal.toFixed(3));
        formatRupiah(subtotalInput);
    });

    // Fungsi untuk format rupiah
    function formatRupiah(input) {
        var value = input.val().replace(/\./g, '');
        input.val(formatRupiahString(value));
    }

    function formatRupiahString(angka) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }
});

</script>




<script>
  $(document).ready(function() {
      $('#barangSelect').on('change', function() {
          var selectedOption = $(this).val();
  
          if (selectedOption !== '') {                        
            $.ajax({
                url: '/penjualan-jasa/update/' + selectedOption, 
                method: 'GET', 
                success: function(response) {
                    // console.log(response.result.id);
                    $('#hargaSatuanInput').val(response.result.harga_jual);
                    formatRupiah($('#hargaSatuanInput'));          
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
          } else {
              // Kosongkan input jika tidak ada opsi yang dipilih
              $('#hargaSatuanInput').val('');
          }
      });
  
      $('.hargaSatuanInput, .jumlah-barang').on('input', function() {
            // Dapatkan nilai harga satuan dan jumlah barang
            var hargaSatuan = parseFloat($(this).closest('tr').find('.hargaSatuanInput').val()) || 0;
            var jumlahBarang = parseFloat($(this).closest('tr').find('.jumlah-barang').val()) || 0;
            
            // Hitung subtotal
            var subtotal = hargaSatuan * jumlahBarang;
            
            // Tampilkan subtotal di input subtotal
            $(this).closest('tr').find('.subtotal').val(subtotal.toFixed(3));
  
            formatRupiah($(this).closest('tr').find('.subtotal'));
        });
  
  
        // Fungsi untuk menambahkan format rupiah
    function formatRupiah(input) {
        var value = input.val().replace(/\./g, '');
        input.val(formatRupiahString(value));
    }
  
    function formatRupiahString(angka) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);
  
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
  
        return rupiah;
    }
  });
</script>



<script>
  $(document).ready(function() {
    $('.dibayar').hide();
    $('.bayar').show();

    $('#pembayaran').change(function() {
      var pembayaran = $(this).val();

      if (pembayaran === 'Credit') {
        $('.dibayar').show(); // Tampilkan div dengan class card
        $('.bayar').hide(); // Sembunyikan div dengan class form-group
      } else if (pembayaran === 'Pilih') {
        $('.bayar').show(); // Tampilkan div dengan class form-group
        $('.dibayar').hide(); // Sembunyikan div dengan class card
      } else if (pembayaran === 'Cash') {
        $('.bayar').show(); // Tampilkan div dengan class form-group
        $('.dibayar').hide(); // Sembunyikan div dengan class card
      }
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


{{-- <script>
    $(document).ready(function(){
        $('#pemasukan').DataTable({
            "responsive": true, 
            "autoWidth": false,
            "processing": true,
            "serverside": true,
            "ajax": "{{ url('dataTable/DataPemasukan') }}",
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'pemasukan',
                name: 'Jenis Pemasukan'
            },{
                data: 'tgl',
                name: 'Tanggal'
            },{
                data: 'total',
                name: 'Total'
            },{
                data: 'keterangan',
                name: 'Keterangan'
            },{
                data: 'aksi',
                name: 'Aksi'
            }]
        });
    });
</script> --}}

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

    $('#total').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });

  </script>
@endpush
