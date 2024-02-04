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
              <strong><h4 >{{-- <i class="fas fa-edit"></i> --}}Data Pemasukan </h4></strong>
            </div>
            
            <div class="card-body">
              
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#md-pemasukan">
                <i class="fas fa-plus"></i>
                Tambah Data
              </button>
             
            </div>
            <!-- /.card -->

            <div class="card-body">
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
              </div>
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- ./row -->

    </div><!-- /.container-fluid -->

    
    <div class="modal fade" id="md-pemasukan">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Pemasukan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ url('/pemasukan/create') }}" method="POST">
              @csrf
              {{-- <div class="form-group">
                <label>Jenis Pemasukan</label>
                <select class="form-control" name='jenis_pemasukan' id="jenis">
                  <option value="">~ Pilih ~</option>
                  @foreach ($pemasukan as $item)
                    @if (old('jenis_pemasukan') == $item->id)
                      <option value="{{ $item->id }}" selected>{{ $item->nama_atribut }}</option>
                    @else
                     <option value="{{ $item->id }}">{{ $item->nama_atribut }}</option>
                    @endif
                  @endforeach
                </select>
              </div>              --}}
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input name="tanggal" type="date" class="form-control" id="tgl" required>
                </div>              
                <div class="form-group">
                  <label for="total">Total</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp. </span>
                      </div>
                      <input name="total" type="text" class="form-control" id="total" required>
                    </div>
                </div>     
                <div class="form-group ">
                  <label for="bukti">Bukti Pembayaran</label> <br>
                  <input type="file" id="bukti" name="bukti">
                </div>
                       
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea name="keterangan" id="ket" class="form-control" rows="4" placeholder="keterangan"></textarea>
                </div>                          
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    
    <!-- /.modal -->

  </section>

@endsection

@push('js')

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

    $('#total').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });

  </script>
@endpush
