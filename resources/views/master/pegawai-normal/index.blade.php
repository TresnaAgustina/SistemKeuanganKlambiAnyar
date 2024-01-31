@extends('layouts.main')
@section('container')
    
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Master</h1>
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
              <strong><h4 >{{-- <i class="fas fa-edit"></i> --}}Pegawai Tetap </h4></strong>
            </div>
            
            <div class="card-body">
              
              <button type="button" class="btn btn-primary test" data-toggle="modal" data-target="#md-pegawai">
                <i class="fas fa-plus"></i>
                Tambah Data
              </button>
             
            </div>
            <!-- /.card -->

            <div class="card-body">
                <table id="pegawai" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Jenis Kelamin</th>
                    <th>Gaji Pokok</th>
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
            <h4 class="modal-title">Tambah Data Pegawai Tetap</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ url('/mstr/pegawai-tetap/create') }}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="nama">Nama Pegawai</label>
                    <input name="nama" type="text" class="form-control" id="nama" required>
                </div>
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input name="nip" type="text" class="form-control" id="nip" required>
                </div>                          
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input name="alamat" type="text" class="form-control" id="alamat" required>
                </div>                          
                <div class="form-group">
                    <label for="no_telp">Nomor Telepon</label>
                    <input name="No_telp" type="text" class="form-control" id="no_telp" required>
                </div>                          
                <div class="form-group">
                    <label for="jk">Jenis Kelamin</label>
                    <input name="JK" type="text" class="form-control" id="jk" required>
                </div>                          
                <div class="form-group">
                    <label for="gaji">Gaji Pokok</label>
                    <input name="gaji" type="text" class="form-control" id="gaji" required>
                </div>                          
                                       
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" id="status" class="form-control">
                    <option value="active">Aktif</option>
                    <option value="inactive">Non-Aktif</option>
                  </select>
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
        $('#pegawai').DataTable({
            "responsive": true, 
            "autoWidth": false,
            "processing": true,
            "serverside": true,
            "ajax": "{{ url('dataTable/PegawaiTetap') }}",
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'nama',
                name: 'Nama'
            },{
                data: 'nip',
                name: 'NIP'
            },{
                data: 'alamat',
                name: 'Alamat'
            },{
                data: 'no_telp',
                name: 'Nomor Telepon'
            },{
                data: 'jenis_kelamin',
                name: 'Jenis Kelamin'
            },{
                data: 'gaji_pokok',
                name: 'Gaji Pokok'
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
      $.ajax({
        url:'/mstr/pegawai-tetap/update/' + id,
        success:function(response){
          $('#test').modal('show');
          $('#nama').val(response.result.nama);
          $('#nip').val(response.result.nip);
          $('#alamat').val(response.result.alamat);
          $('#no_telp').val(response.result.no_telp);
          $('#jk').val(response.result.jenis_kelamain);
          $('#gaji').val(response.result.gaji_pokok);
          var statusValue = response.result.status;
          var selectElement = document.getElementById("status");
          for (var i = 0; i < selectElement.options.length; i++) {
              if (selectElement.options[i].value === statusValue) {
                  selectElement.options[i].selected = true;
                  break;
              }
          }
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
