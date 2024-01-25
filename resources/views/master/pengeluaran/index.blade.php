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

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
                {{-- <i class="fas fa-edit"></i> --}}
                Data Pengeluaran
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

    
    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Pengeluaran</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Atribut</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" >
                </div>
                <div class="form-group">
                  <label>Tipe</label>
                  <select class="form-control">
                    <option>- pilih -</option>
                    <option>Perusahaan</option>
                    <option>Pribadi</option>
                  </select>
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
