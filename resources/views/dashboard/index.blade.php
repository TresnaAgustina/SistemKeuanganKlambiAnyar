@extends('layouts.main')
@section('container')

<div class="swal" data-swal="{{ session('success') }}">
</div>
<div class="error" data-swal="{{ session('error') }}">
</div>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3 id="saldo">{{ $saldo }}</h3>
  
            <p>Total Saldo Kas</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3 id="income">{{ $total_income }}</h3>
  
            <p>Total Pemasukan</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
      <!-- ./col -->
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3 id="spend">{{ $total_spend }}</h3>
  
            <p>Pengeluaran</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $total_pgw }}</h3>
  
            <p>Jumlah Pegawai</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
      <!-- ./col -->
      
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0">Graphic Penjualan <sup>/Bulan</sup></h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

      <div class="container-fluid">
        <div class="col-12">
          <canvas id="myBarChart" height="110px"></canvas>
        </div>
      </div>
      
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0">Graphic Pengeluaran dan Pemasukan <sup>/Hari</sup></h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
      <div class="container-fluid">
        <div class="col-12">
          <canvas id="myLineChart" height="110px"></canvas>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('js')
      {{-- // sweetalert notification --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

  // buat format rupiah untuk spend dan income
  const spend = document.getElementById('spend');
  const income = document.getElementById('income');
  const saldo = document.getElementById('saldo');

  spend.innerHTML = formatRupiah(spend.innerHTML, 'Rp. ');
  income.innerHTML = formatRupiah(income.innerHTML, 'Rp. ');
  saldo.innerHTML = formatRupiah(saldo.innerHTML, 'Rp. ');

  function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }

  // Chart Js
  // Menggunakan data yang berasal dari controller
  var barChartData = {
      labels: {!! json_encode(range(1, 12)) !!}, // Bulan 1 sampai 12
      datasets: [
          {
              label: 'Penjualan Lain',
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 1,
              data: {!! json_encode(array_column($chartData, 'penjualan_lain')) !!}
          },
          {
              label: 'Penjualan Jasa Jarit',
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1,
              data: {!! json_encode(array_column($chartData, 'penjualan_jasa')) !!}
          }
      ]
  };

  // Inisialisasi Chart
  var ctx = document.getElementById('myBarChart').getContext('2d');
  var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: barChartData,
      options: {
          responsive: true,
          scales: {
              x: {
                  beginAtZero: true
              },
              y: {
                  beginAtZero: true
              }
          }
      }
  });

  // get total day in this month
var totalDay = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate();

// Line Chart
var lineChartData = {
    labels: Array.from({ length: totalDay }, (_, i) => i + 1), // Range tanggal sesuai jumlah hari dalam bulan
    datasets: [
        {
            label: 'pemasukan',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            data: {!! json_encode(array_column($lineChartData, 'pemasukan')) !!}
        },
        {
            label: 'pengeluaran',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            data: {!! json_encode(array_column($lineChartData, 'pengeluaran')) !!}
        }
    ]
};


  // Inisialisasi Chart
  var ctx = document.getElementById('myLineChart').getContext('2d');
  var myLineChart = new Chart(ctx, {
      type: 'line',
      data: lineChartData,
      options: {
          responsive: true,
          pointStyle: 'rect',
          pointRadius: 10,
          pointHoverRadius: 15,
          scales: {
              x: {
                  beginAtZero: true
              },
              y: {
                  beginAtZero: true
              }
          }
      }
  });

</script>

  @endpush



