@extends('layouts.main')
@section('container')
    
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Data Kasbon </h1>
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
            <strong><h4 >Bayar Kasbon Pegawai Tetap  </h4></strong>
          </div>
          
          <form action="/kasbon-tetap/bayar/{{ $data->id }}" method="POST">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label>Nama Pegawai</label>
                <input readonly name="nama" type="text" class="form-control" value="{{ $data->pegawai_normal->nama }}" >
              </div>
              <div class="form-group">
                <label>Tanggal Kasbon</label>
                <input readonly name="tgl" type="text" class="form-control" value="{{ date('d-m-Y', strtotime($data->tanggal )) }}" >
              </div>
              <div class="form-group">
                <label>Jumlah Kasbon</label>
                <input readonly name="jmlh_kasbon" type="text" class="form-control" value="Rp. {{ number_format($data->jumlah_kasbon)}}" >
              </div>
              <div class="form-group">
                <label>Sisa Kasbon</label>
                <input readonly name="sisa" type="text" class="form-control" value="Rp. {{ number_format($data->sisa)}}" >
              </div>
              <div class="form-group">
                <label for="jumlah">Jumlah Bayar</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp. </span>
                    </div>
                    <input name="jumlah_bayar" type="text" class="form-control jumlah" required>
                  </div>
              </div>     
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input name="tanggal" type="date" class="form-control" id="tgl" required>
              </div>          
              
              <button type="submit" class="btn btn-success mt-4">Simpan</button>
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

