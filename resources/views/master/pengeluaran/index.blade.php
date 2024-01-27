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

{{-- error and success handling --}}
@if (session('pesan'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('pesan') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button> 
</div>
@endif
{{-- end --}}

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card card-primary card-outline">
            <div class="card-header">
              <strong><h4 >{{-- <i class="fas fa-edit"></i> --}}Data pengeluaran </h4></strong>
            </div>
            
            <div class="card-body">
              
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#md-pengeluaran">
                <i class="fas fa-plus"></i>
                Tambah Data
              </button>
             
            </div>
            <!-- /.card -->

            <div class="card-body">
                <table id="pengeluaran" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Nama Atribut</th>
                    <th>Tipe</th>
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

    
    <div class="modal fade" id="md-pengeluaran">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Pengeluaran</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="{{ url('/mstr/pengeluaran/create') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_atribut">Nama Atribut</label>
                    <input name="nama_atribut" type="text" class="form-control" id="namaAtribut" >
                </div>
                <div class="form-group">
                    <label for="tipe">Tipe</label>
                    <input type="text" class="form-control" id="tipe" name="tipe" required >
                </div>
                {{-- <div class="form-group">
                  <label>Tipe</label>
                  <select name="tipe" class="form-control">
                    <option>- pilih -</option>
                    <option value="1">Perusahaan</option>
                    <option value="2">Pribadi</option>
                  </select>
                </div>                          --}}
                                        
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
<script>
    $(document).ready(function(){
        $('#pengeluaran').DataTable({
            "responsive": true, 
            "autoWidth": false,
            "processing": true,
            "serverside": true,
            "ajax": "{{ url('dataTable/pengeluaran') }}",
            "columns": [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'nama_atribut',
                name: 'Nama Atribut'
            },{
                data: 'tipe',
                name: 'Tipe'
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
          url:'/mstr/pengeluaran/update/' + id,
          success:function(response){
            $('#test').modal('show');
            $('#nama').val(response.result.nama_atribut);
            $('#tipe').val(response.result.tipe);
            $('.simpan').click(function() {
              simpan(id);
            });
          }
        });
    });
  
    function simpan(id = ''){
      if (id == ''){
        var var_url = '/mstr/pengeluaran/create';
        var var_type = 'POST';
      }else{
        var var_url = '/mstr/pengeluaran/update/' + id;
        var var_type = 'POST';
      }
      $.ajax({
        url: var_url,
        type: var_type,
        data: {
            nama: $('#nama').val(),
            tipe: $('#tipe').val()
        },
        success: function(response){
          $('#pengeluaran').DataTable().ajax.reload();
        }
      });
    }
  
  // hapus data pada form ketika di tutup
    $(document).ready(function(){
        $('#md-pengeluaran').on('hidden.bs.modal', function(){
            $(this).find('input').val(''); // Mengosongkan nilai input di dalam modal
        });
    });
  </script>

@endpush
