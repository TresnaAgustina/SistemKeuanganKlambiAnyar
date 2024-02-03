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
<div class="error" data-swal="{{ session('error') }}">
</div>


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-money-check-alt"></i></span>
      
            <div class="info-box-content">
              <span class="info-box-text">SALDO BANK</span>
              <span class="info-box-number">Rp. {{ number_format($bank) }} </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-money-check-alt"></i></span>
      
            <div class="info-box-content">
              <span class="info-box-text">SALDO KAS</span>
              <span class="info-box-number">Rp. {{ number_format($kas) }}  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
       
      </div>

      <div class="row">
        <div class="col-md-12">
          
          <div class="card card-primary card-outline">
            <div class="card-body">
              
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#md-isiBank">
                <i class="fas fa-plus"></i>
                Isi Saldo Bank
              </button>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#md-isiKas">
                <i class="fas fa-plus"></i>
               Isi Saldo Kas
              </button>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#md-trfBank">
                Transfer Saldo Bank    <i class="fas fa-arrow-right"></i>     Kas
              </button>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#md-trfKas">
                Transfer Saldo Kas <i class="fas fa-arrow-right"></i> Bank
              </button>
             
            </div>
            <!-- /.card -->
          </div>

          <div class="card card-primary card-outline">
            <div class="card-header">
              <strong><h4 >{{-- <i class="fas fa-edit"></i> --}}Riwayat Transaksi  </h4></strong>
            </div>

            <div class="card-body">
                <table id="histori" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Keterangan</th>
                    <th>Tipe</th>
                    <th>jumlah</th>
                    <th>Tanggal</th>
                   
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

    
    <div class="modal fade" id="md-isiBank">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Isi Saldo Bank</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ url('/keuangan/saldo-bank') }}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="tipe">Tipe</label>
                    <input value="Isi Saldo Bank" name="tipe" type="text" class="form-control" id="tipe" required>
                </div>      
                <div class="form-group">
                  <label for="jumlah">Jumlah</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp. </span>
                      </div>
                      <input name="jumlah" type="text" class="form-control" id="jmlBank" required>
                    </div>
                </div>   
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input name="tanggal" type="date" class="form-control" id="tglBank" required>
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
    <div class="modal fade" id="md-isiKas">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Isi Saldo Kas</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ url('/keuangan/saldo-kas') }}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="tipe">Tipe</label>
                    <input value="Isi Saldo Kas" name="tipe" type="text" class="form-control" id="tipe" required>
                </div>      
                <div class="form-group">
                  <label for="jumlah">Jumlah</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp. </span>
                      </div>
                      <input name="jumlah" type="text" class="form-control" id="jmlKas" required>
                    </div>
                </div>   
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input name="tanggal" type="date" class="form-control" id="tglKas" required>
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
    <div class="modal fade" id="md-trfBank">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Transfer Saldo Bank Ke Kas</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ url('/keuangan/transfer-bank') }}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="tipe">Tipe</label>
                    <input value="Transfer Saldo Bank Ke Kas" name="tipe" type="text" class="form-control" id="tipe" required>
                </div>      
                <div class="form-group">
                  <label for="jumlah">Jumlah</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp. </span>
                      </div>
                      <input name="jumlah" type="text" class="form-control" id="jml_trfBank" required>
                    </div>
                </div>   
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input name="tanggal" type="date" class="form-control" id="tgl_trfBank" required>
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
    <div class="modal fade" id="md-trfKas">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Transfer Saldo Kas Ke Bank</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ url('/keuangan/transfer-kas') }}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="tipe">Tipe</label>
                    <input value="Transfer Saldo Kas Ke Bank" name="tipe" type="text" class="form-control" id="tipe" required>
                </div>      
                <div class="form-group">
                  <label for="jumlah">Jumlah</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp. </span>
                      </div>
                      <input name="jumlah" type="text" class="form-control" id="jml_trfKas" required>
                    </div>
                </div>   
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input name="tanggal" type="date" class="form-control" id="tgl_trfKas" required>
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
                        url: '/mstr/keuangan/delete/' + id, 
                        success: function(data) {
                            Swal.fire({
                              title: 'berhasil',
                              text: data.message,
                              icon: 'success'
                            }).then((result) => {
                               window.location.href = '/mstr/keuangan/all';
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
        $('#histori').DataTable({
            "responsive": true, 
            "autoWidth": false,
            "processing": true,
            "serverside": true,
            "ajax": "{{ url('dataTable/histori') }}",
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'keterangan',
                name: 'Keterangan'
            },{
                data: 'tipe',
                name: 'Tipe'
            },{
                data: 'jml',
                name: 'Jumlah'
            },{
                data: 'tgl',
                name: 'Tanggal'
            }]
        });
    });
</script>

<script>
  // hapus data pada form ketika di tutup
    $(document).ready(function(){
        $('#md-keuangan').on('hidden.bs.modal', function(){
            $(this).find('input').val(''); // Mengosongkan nilai input di dalam modal
        });
    });

    //set tanggal otomatis
    $(document).ready(function() {
      // Mendapatkan tanggal sekarang dalam format YYYY-MM-DD
      var tanggalSekarang = new Date().toISOString().split('T')[0];
      $('#tglBank').val(tanggalSekarang);
      $('#tglKas').val(tanggalSekarang);
      $('#tgl_trfBank').val(tanggalSekarang);
      $('#tgl_trfKas').val(tanggalSekarang);
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

    $('#jmlKas').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });
    $('#jmlBank').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });
    $('#jml_trfKas').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });
    $('#jml_trfBank').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });
  </script>


@endpush
