@extends('layouts.main')
@section('container')
    
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Kasbon</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

{{-- error and success handling with sweetalert --}}
<div class="swal" data-swal="{{ session('success') }}">
</div>
<div class="error" data-swal="{{ session('pesan') }}">
</div>

{{-- error and success handling --}}
{{-- @if (session('pesan'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('pesan') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button> 
</div>
@endif --}}
{{-- end --}}

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card card-primary card-outline">
            <div class="card-header">
              <strong><h4 >{{-- <i class="fas fa-edit"></i> --}}Pegawai Rumahan </h4></strong>
            </div>
            
            <div class="card-body">
              
              <button type="button" class="btn btn-primary test" data-toggle="modal" data-target="#md-pegawai">
                <i class="fas fa-plus"></i>
                Tambah Data
              </button>
             
            </div>
            <!-- /.card -->

            <div class="card-body">
                <table id="kasbonRumahan" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Nama Pegawai</th>
                    <th>Tanggal Kasbon</th>
                    <th>Jumlah Kasbon</th>
                    <th>Sisa Kasbon</th>
                    <th>Status</th>
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

    
    <div class="modal fade" id="md-pegawai">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Kasbon Rumahan Tetap</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ url('/kasbon-rumahan/create') }}" method="POST">
              @csrf
              <div class="form-group">
                <label>Nama Pegawai</label>
                <select class="form-control" name='id_pgw_rumahan' id="nama">
                  <option value="">~ Pilih ~</option>
                  @foreach ($data as $item)
                    @if (old('id_pgw_rumahan') == $item->id)
                      <option value="{{ $item->id }}" selected>{{ $item->nama }}</option>
                    @else
                     <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endif
                  @endforeach
                </select>
              </div>                         
                <div class="form-group">
                  <label for="jumlah">Jumlah Kasbon</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp. </span>
                      </div>
                      <input name="jumlah_kasbon" type="text" class="form-control jumlah" required>
                    </div>
                </div>        
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input name="tanggal" type="date" class="form-control" id="tgl" required>
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
                        type: 'GET',
                        url: '/mstr/pegawai-tetap/delete/' + id, 
                        success: function(data) {
                            Swal.fire({
                              title: 'berhasil',
                              text: data.message,
                              icon: 'success'
                            }).then((result) => {
                               window.location.href = '/mstr/pegawai-tetap/all';
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


{{-- //Datatble Config --}}
<script>
    $(document).ready(function(){
        $('#kasbonRumahan').DataTable({
            "responsive": true, 
            "autoWidth": false,
            "processing": true,
            "serverside": true,
            "ajax": "{{ url('dataTable/KasbonRumahan') }}",
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'nama',
                name: 'Nama Pegawai'
            },{
                data: 'tgl',
                name: 'Tanggal Kasbon'
            },{
                data: 'jumlah',
                name: 'Jumlah Kasbon'
            },{
                data: 'sisa',
                name: 'Sisa Kasbon'
            },{
                data: 'status',
                name: 'Status'
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

  $('body').on('click', '.update-btn', function(e){
      var id = $(this).data('id');
      console.log(id);
      $.ajax({
        url:'/mstr/pegawai-tetap/update/' + id,
        success:function(response){
          $('#test').modal('show');
          $('#nama').val(response.result.nama);
          $('#jk').val(response.result.jenis_kelamin);
          $('#alamat').val(response.result.alamat);
          $('#no_telp').val(response.result.no_telp);
          $('#gaji').val(response.result.gaji_pokok);
          $('#status').val(response.result.status);
          var statusValue = response.result.status;
          var selectElement = document.getElementById("status");
          for (var i = 0; i < selectElement.options.length; i++) {
              if (selectElement.options[i].value === statusValue) {
                  selectElement.options[i].selected = true;
                  break;
              }
          }
          console.log(response);

          var jkValue = response.result.jenis_kelamin;
          var selectJK = document.getElementById("jk");
          for (var i = 0; i < selectJK.options.length; i++) {
              if (selectJK.options[i].value === jkValue) {
                  selectJK.options[i].selected = true;
                  break;
              }
          }

          // Menangani klik pada tombol Simpan di dalam modal
          $('.simpan').click(function(){
                // Mengubah action dan method form
                $('form').attr('action', '/mstr/pegawai-tetap/update/' + id);
                $('form').attr('method', 'POST');
                // Submit form
                $('form').submit();
            });
        }
      });
  });

// hapus data pada form ketika di tutup
  $(document).ready(function(){
      $('#md-pegawai').on('hidden.bs.modal', function(){
          $(this).find('input').val(''); // Mengosongkan nilai input di dalam modal
      });
  });
</script>


@endpush
