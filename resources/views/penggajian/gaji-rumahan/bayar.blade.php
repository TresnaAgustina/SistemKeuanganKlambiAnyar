@extends('layouts.main')
@section('container')
    
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Data Gaji </h1>
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
            <strong><h4 >Potong Gaji Pegawai Rumahan  </h4></strong>
          </div>
          
          <form action="/gaji/pegawai-rumahan/potong-gaji" method="POST">
            @csrf
            <div class="card-body">
              <input name="id_kasbon_rumahan" hidden type="number" value="{{ $data->id }}">
              <div class="form-group">
                <label>Nama Pegawai</label>
                <input readonly name="nama" type="text" class="form-control" value="{{ $data->pegawai_rumahan->nama }}" >
              </div>
              <div class="form-group">
                <label>Gaji Final</label>
                <input readonly name="jmlh_kasbon" type="text" class="form-control" value="Rp. {{ number_format($gaji)}}" >
              </div>
              <div class="form-group">
                <label>Jumlah Kasbon</label>
                <input readonly name="jmlh_kasbon" type="text" class="form-control" value="Rp. {{ number_format($kasbon)}}" >
              </div>
              <div class="form-group">
                <label>Sisa Kasbon</label>
                <input readonly name="jmlh_kasbon" type="text" class="form-control" value="Rp. {{ number_format($sisa)}}" >
              </div>
              <div class="form-group">
                <label for="jumlah">Jumlah Potong Gaji</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp. </span>
                    </div>
                    <input name="jumlah_potong" type="text" class="form-control jumlah" >
                  </div>
              </div>     
              <div class="form-group">
                <label for="jumlah">Kembalikan Potong Gaji</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp. </span>
                    </div>
                    <input name="jumlah_beri" type="text" class="form-control jumlah_beri" >
                  </div>
              </div>     
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input name="tanggal" type="date" class="form-control" id="tgl" required>
              </div>          
              
              <button type="text" class="btn btn-success mt-4">Simpan</button>
            </div>
          </form>
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- ./row -->

  </div><!-- /.container-fluid -->

</section>

@endsection

@push('js')
    <script>
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

    $('.jumlah').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });
    $('.jumlah_beri').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(formatRupiah(value));
    });

    </script>
@endpush

