@extends('layouts.main')
@section('container')
    
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Aktivitas Pegawai</h1>
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
          
          <form action="/aktivitas/create/{{ $data->nip }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <input hidden id="id" name="id_pgw_rumahan" type="text" value="{{ $data->id }}">
              <div class="form-group">
                <label for="nip">NIP</label>
                <input readonly name="nip" type="text" class="form-control" id="nip" value="{{ $data->nip }}">
              </div>          
              <div class="form-group">
                <label for="nama">Nama Pegawai</label>
                <input readonly name="nama" type="text" class="form-control" id="nama" value="{{ $data->nama }}">
              </div>          
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input name="activity[0][tanggal]" type="date" class="form-control" id="tgl" required>
              </div>          
              
            </div>

            <div class="card-header">
              <strong><h4 >Tambah Data </h4></strong>
            </div>
            <div class="card-body">
              <table id="barang" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Jenis Jaritan</th>
                  <th>Jumlah Jarit</th>
                  <th>Harga Satuan</th>
                  <th>Subtotal</th>
                  <th><a href="javascript:void(0)" class="btn btn-success btn-sm addRow"> <i class="fas fa-plus"></i> </a></th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <select class="form-control barangSelect" name="activity[0][detail][0][id_mstr_jaritan]">
                      <option value="">~ Pilih ~</option>
                      @foreach ($jaritan as $item)
                        @if (old('activity[0][detail][0][id_mstr_jaritan]') == $item->id)
                          <option data-id={{ $item->id }} value="{{ $item->id }}" selected>{{ $item->jenis_jaritan }}</option>
                        @else
                         <option data-id={{ $item->id }} value="{{ $item->id }}">{{ $item->jenis_jaritan }}</option>
                        @endif
                      @endforeach
                    </select>
                    </td>
                    <td><input type="number" name="activity[0][detail][0][jumlah_barang]" class="form-control jumlah-barang"></td>
                    <td><input type="text" name="activity[0][detail][0][harga_satuan]" class="form-control hargaSatuanInput"></td>
                    <td><input type="text" name="activity[0][detail][0][subtotal]" class="form-control subtotal"></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td style="text-align: center; font-weight: bold;" colspan="3" >Total Bayar</td>
                    <td class="total" ></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
              <button type="text" class="btn btn-success mt-4">Simpan</button>
            </div>
          </form>
          </div>
          <div class="card card-primary card-outline">
            <div class="card-header">
              <strong><h4 >{{-- <i class="fas fa-edit"></i> --}}Data Aktivitas </h4></strong>
            </div>
          
            <div class="card-body">
                <table id="aktivitas" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nomor</th>
                      <th>NIP</th>
                      <th>Nama Pegawai</th>
                      <th>Tanggal Aktivitas</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                </table>
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
      $('#aktivitas').DataTable({
            "responsive": true, 
            "autoWidth": false,
            "processing": true,
            "serverside": true,
            "ajax":{
              "url": "/dataTable/Aktivitas",
              "data": function (d) {
                d.id = $('#id').val(); // Ambil nilai ID dari elemen HTML yang sesuai
              }
            },
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'nip',
                name: 'Nip'
            },{
                data: 'nama',
                name: 'Nama'
            },{
                data: 'tgl',
                name: 'Tanggal'
            },{
                data: 'aksi',
                name: 'Aksi'
            }]
        });
    });
</script>

<script>
   $('#barang').on('click', '.addRow', function(){
    var rowCount = $('#barang tbody tr').length; // Hitung jumlah baris dalam tabel
    var newIndex = rowCount; // Tentukan indeks baru
        var tr = `<tr> 
          <td>
            <select class="form-control barangSelect" name="activity[0][detail][${newIndex}][id_mstr_jaritan]">
              <option value="">~ Pilih ~</option>
              @foreach ($jaritan as $item)
                @if (old('activity[0][detail][${newIndex}][id_mstr_jaritan]') == $item->id)
                  <option data-id={{ $item->id }} value="{{ $item->id }}" selected>{{ $item->jenis_jaritan }}</option>
                @else
                  <option data-id={{ $item->id }} value="{{ $item->id }}">{{ $item->jenis_jaritan }}</option>
                @endif
              @endforeach
            </select>
          </td>
          <td><input type="number" name="activity[0][detail][${newIndex}][jumlah_barang]" class="form-control jumlah-barang"></td>
          <td><input type="text" name="activity[0][detail][${newIndex}][harga_satuan]" class="form-control hargaSatuanInput"></td>
          <td><input type="text" name="activity[0][detail][${newIndex}][subtotal]" class="form-control subtotal"></td>
          <td><a href="javascript:void(0)" class="btn btn-danger btn-sm deleteRow">
              <i class="fas fa-minus"></i></a>
          </td>
          </tr>`;
        $('#barang tbody').append(tr);
    });

    // Menggunakan event delegation untuk menghapus baris
    $('tbody').on('click', '.deleteRow', function(){
      var subtotal = parseFloat($(this).closest('tr').find('.subtotal').val()) || 0;
      var total = parseFloat($('.total').text()) || 0;
      
      // Kurangi subtotal dari total
      total -= subtotal;

    // Perbarui total yang ditampilkan
    $('.total').text(total);
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
                    hargaSatuanInput.val(response.result.harga_dalam);
                    formatTest(hargaSatuanInput);          
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            hargaSatuanInput.val('');
        }
        updateSubtotal($(this).closest('tr'));
    });

    // Event handler untuk perubahan pada elemen dengan kelas .hargaSatuanInput dan .jumlah-barang
    $(document).on('input', '.hargaSatuanInput, .jumlah-barang', function() {
        var hargaSatuan = parseFloat($(this).closest('tr').find('.hargaSatuanInput').val()) || 0;
        var jumlahBarang = parseFloat($(this).closest('tr').find('.jumlah-barang').val()) || 0;
        var subtotalInput = $(this).closest('tr').find('.subtotal');

        var subtotal = hargaSatuan * jumlahBarang;
        // subtotalInput.val(subtotal);
        updateSubtotal($(this).closest('tr'));
        subtotalInput.val(subtotal.toFixed(3));
        formatTest(subtotalInput);
    });

     // Fungsi untuk memperbarui subtotal untuk baris tertentu
     function updateSubtotal(row) {
        var hargaSatuan = parseFloat(row.find('.hargaSatuanInput').val()) || 0;
        var jumlahBarang = parseFloat(row.find('.jumlah-barang').val()) || 0;
        var subtotal = hargaSatuan * jumlahBarang;
        row.find('.subtotal').val(subtotal.toFixed(3));

        // Panggil fungsi untuk menghitung total keseluruhan setelah memperbarui subtotal
        calculateTotal();
    }

    // Fungsi untuk menghitung total keseluruhan
    function calculateTotal() {
        var total = 0;
        $('.subtotal').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('.total').text(total.toFixed(3));
        $('.total').text(formatRupiah(total.toFixed(3))); // Update total dengan format rupiah

    }

    // Fungsi untuk format rupiah
    function formatTest(input) {
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

    // Fungsi untuk format rupiah
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
});

</script>

<script>
  $(document).ready(function() {
    $('.dibayar').hide();
    $('.bayar').show();

    $('#pembayaran').change(function() {
      var pembayaran = $(this).val();

      if (pembayaran === 'credit') {
            $('.dibayar').show().find('input').prop('required', true); 
            $('.bayar').hide().find('input').prop('required', false); 
        } else if (pembayaran === 'Pilih') {
            $('.bayar').show().find('input').prop('required', false); 
            $('.dibayar').hide().find('input').prop('required', false); 
        } else if (pembayaran === 'cash') {
            $('.bayar').show().find('input').prop('required', true); 
            $('.dibayar').hide().find('input').prop('required', false); 
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

    $('.pembayaranAwal').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });
    $('.pembayaranCash').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });

  </script>


@endpush
