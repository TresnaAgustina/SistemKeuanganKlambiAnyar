@extends('layouts.main')
@section('container')
    
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Gaji</h1>
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
          
          <div class="card card-primary card-outline">
            <div class="card-header">
              <strong><h4 >Pegawai Rumahan </h4></strong>
            </div>

            <div class="card-body">
              {{-- <h5 style="font-weight: bold;">Jumlah Bayar Gaji :  Rp. </h4> --}}
                <span class="badge bg-danger" style="font-size: 12px;">
                  <h5 style="font-weight: bold;">Jumlah Bayar Gaji :  Rp. {{ number_format($gaji) }}</h5>
                </span>
            </div>

            <div class="card-body">
                <table id="gajiTetap" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Nama Pegawai</th>
                    <th>Gaji Final</th>
                    <th>Jumlah Kasbon</th>
                    <th>Sisa Kasbon</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                 
              </div>
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- ./row -->

    </div><!-- /.container-fluid -->
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
    $('#gajiTetap').DataTable({
        "responsive": true, 
        "autoWidth": false,
        "processing": true,
        "serverside": true,
        "ajax": "{{ url('dataTable/gajiRumahan') }}",
        "columns": [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },{
            data: 'nama',
            name: 'Nama Pegawai'
        },{
            data: 'final',
            name: 'Gaji Final'
        },{
            data: 'kasbon',
            name: 'Jumlah Kasbon'
        },{
            data: 'sisa',
            name: 'Sisa Kasbon'
        },{
            data: 'aksi',
            name: 'Aksi'
        }],
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
