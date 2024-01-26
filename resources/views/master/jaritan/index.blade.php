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
            <form>
                <div class="form-group">
                    <label for="jenis">Jenis Jaritan</label>
                    <input type="text" class="form-control" name="jenis" id="jenis" required>
                </div>
                <div class="form-group">
                    <label for="hargaDalam">Harga Dalam</label>
                    <input type="text" class="form-control" name="hargaDalam" id="hargaDalam" required>
                </div>                          
                <div class="form-group">
                    <label for="hargaLuar">Harga Luar</label>
                    <input type="text" class="form-control" name="hargaLuar" id="hargaLuar" required>
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
          $('.simpan').click(function() {
            simpan(id);
          });
        }
      });
  });

  function simpan(id = ''){
    if (id == ''){
      var var_url = '/mstr/jaritan/create';
      var var_type = 'POST';
    }else{
      var var_url = '/mstr/jaritan/update/' + id;
      var var_type = 'POST';
    }
    $.ajax({
      url: var_url,
      type: var_type,
      data: {
          jenis: $('#jenis').val(),
          hargaDalam: $('#hargaDalam').val(),
          hargaLuar: $('#hargaLuar').val()
      },
      success: function(response){
        $('#jaritan').DataTable().ajax.reload();
      }
    });
  }

// hapus data pada form ketika di tutup
  $(document).ready(function(){
      $('#md-jaritan').on('hidden.bs.modal', function(){
          $(this).find('input').val(''); // Mengosongkan nilai input di dalam modal
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
