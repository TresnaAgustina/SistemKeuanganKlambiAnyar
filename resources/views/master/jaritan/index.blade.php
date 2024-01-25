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
              <h3 class="card-title">
                {{-- <i class="fas fa-edit"></i> --}}
                Data Jaritan
              </h3>
            </div>
            
            <div class="card-body">
              
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
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

    
    <div class="modal fade" id="modal-lg">
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
                    <label for="exampleInputEmail1">Jenis Jaritan</label>
                    <input name="jenis_jaritan" type="text" class="form-control" id="exampleInputEmail1" >
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Harga Dalam</label>
                    <input name="harga_dalam" type="text" class="form-control" id="exampleInputPassword1" >
                </div>                          
                <div class="form-group">
                    <label for="exampleInputPassword1">Harga Luar</label>
                    <input name="harga_luar" type="text" class="form-control" id="exampleInputPassword1" >
                </div>                          

                {{-- <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div> --}}

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
                data: 'harga_dalam',
                name: 'Harga Dalam'
            },{
                data: 'harga_luar',
                name: 'Harga Luar'
            },{
                data: 'aksi',
                name: 'Aksi'
            }]
        });
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