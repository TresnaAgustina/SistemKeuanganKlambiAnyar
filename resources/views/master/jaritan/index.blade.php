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
              <strong><h4 >{{-- <i class="fas fa-edit"></i> --}}Data Jaritan </h4></strong>
            </div>
            
            <div class="card-body">
              
              <button type="button" class="btn btn-primary test" data-toggle="modal" data-target="#md-jaritan">
                <i class="fas fa-plus"></i>
                Tambah Data
              </button>
             
            </div>
            <!-- /.card -->

            <div class="card-body">
                <table id="jaritan" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Jenis Jaritan</th>
                    <th>Harga Dalam</th>
                    <th>Harga Luar</th>
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

    
    <div class="modal fade" id="md-jaritan">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Jaritan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ url('/mstr/jaritan/create') }}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="jenis">Jenis Jaritan</label>
                    <input name="jenis_jaritan" type="text" class="form-control" id="jenis" required>
                </div>
                <div class="form-group">
                    <label for="hargaDalam">Harga Dalam</label>
                    <input name="harga_dalam" type="text" class="form-control" id="hargaDalam" required>
                </div>                          
                <div class="form-group">
                    <label for="hargaLuar">Harga Luar</label>
                    <input name="harga_luar" type="text" class="form-control" id="hargaLuar" required>
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
                        url: '/mstr/jaritan/delete/' + id, 
                        success: function(data) {
                            Swal.fire({
                              title: 'berhasil',
                              text: data.message,
                              icon: 'success'
                            }).then((result) => {
                               window.location.href = '/mstr/jaritan/all';
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
        $('#jaritan').DataTable({
            "responsive": true, 
            "autoWidth": false,
            "processing": true,
            "serverside": true,
            "ajax": "{{ url('dataTable/jaritan') }}",
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'jenis_jaritan',
                name: 'Jenis Jaritan'
            },{
                data: 'harga dalam',
                name: 'Harga Dalam'
            },{
                data: 'harga luar',
                name: 'Harga Luar'
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
        url:'/mstr/jaritan/update/' + id,
        success:function(response){
          $('#test').modal('show');
          $('#jenis').val(response.result.jenis_jaritan);
          $('#hargaDalam').val(response.result.harga_dalam);
          $('#hargaLuar').val(response.result.harga_luar);
           // Menangani klik pada tombol Simpan di dalam modal
           $('.simpan').click(function(){
                // Mengubah action dan method form
                $('form').attr('action', '/mstr/jaritan/update/' + id);
                $('form').attr('method', 'POST');
                // Submit form
                $('form').submit();
            });
        }
      });
  });

// hapus data pada form ketika di tutup
  $(document).ready(function(){
      $('#md-jaritan').on('hidden.bs.modal', function(){
          $(this).find('input').val(''); // Mengosongkan nilai input di dalam modal
      });
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

    $('#hargaDalam').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });
    $('#hargaLuar').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });
</script>

{{-- <script>
    $(document).ready(function(){
        $('#jaritan').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["excel", "pdf", "print"],
            "processing": true,
            "serverside": true,
            "ajax": "{{ url('dataTable/jaritan') }}",
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'jenis_jaritan',
                name: 'Jenis Jaritan'
            },{
                data: 'harga_dalam',
                name: 'Harga Dalam'
            },{
                data: 'harga_luar',
                name: 'Harga Luar'
            },{
                data: 'aksi',
                name: 'Aksi'
            }],
            "initComplete": function () {
                this.api().buttons().container().appendTo('#jaritan_wrapper .col-md-6:eq(0)');
            }
        });
    });
</script> --}}



@endpush
