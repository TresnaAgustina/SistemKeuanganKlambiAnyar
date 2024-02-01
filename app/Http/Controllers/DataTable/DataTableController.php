<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Master_Jaritan;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Master_Barang;
use App\Models\Master_Customer;
use App\Models\Master_Pemasukan;
use App\Models\Master_Pengeluaran;
use App\Models\Pegawai_Normal;
use App\Models\Pegawai_Rumahan;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Penjualan_Lain;

class DataTableController extends Controller
{
    public function DataJaritan()
    {
        $coba = Master_Jaritan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('master.jaritan.tombol')->with('data', $data);
        })
        ->make(true);
    }

    public function DataPemasukan()
    {
        $coba = Master_Pemasukan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('master.pemasukan.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function DataPengeluaran()
    {
        $coba = Master_Pengeluaran::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('master.pengeluaran.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function Pemasukan()
    {
        $coba = Pemasukan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('pemasukan', function($data){
            return $data->master_pemasukan->nama_atribut;
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.pemasukan.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function Pengeluaran()
    {
        $coba = Pengeluaran::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('pengeluaran', function($data){
            return $data->master_pengeluaran->nama_atribut;
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.pengeluaran.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function Penjualan()
    {
        $coba = Penjualan_Lain::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('penjualan', function($data){
            return $data->master_pengeluaran->nama_atribut;
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.pengeluaran.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function PegawaiTetap()
    {
        $coba = Pegawai_Normal::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('status', function ($data) {
            if ($data->status == "inactive") {
                // return '<span class="label label-success">Aktif</span>';
                return '<span class="badge bg-warning" style="font-size: 12px;">Tidak Aktif</span>';
            } else {
                return '<span class="badge bg-success" style="font-size: 12px;">Aktif</span>';
            }
        }) 
        ->addColumn('aksi', function($data){
            return view('Master.pegawai-tetap.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }
    public function PegawaiRumahan()
    {
        $coba = Pegawai_Rumahan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('status', function ($data) {
            if ($data->status == "inactive") {
                // return '<span class="label label-success">Aktif</span>';
                return '<span class="badge bg-warning" style="font-size: 12px;">Tidak Aktif</span>';
            } else {
                return '<span class="badge bg-success" style="font-size: 12px;">Aktif</span>';
            }
        }) 
        ->addColumn('aksi', function($data){
            return view('Master.pegawai-rumahan.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }

    public function customer()
    {
        $coba = Master_Customer::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('status', function ($data) {
            if ($data->status_customer == 'tidak aktif') {
                // return '<span class="label label-success">Aktif</span>';
                return '<span class="badge bg-warning" style="font-size: 12px;">Tidak Aktif</span>';
            } else {
                return '<span class="badge bg-success" style="font-size: 12px;">Aktif</span>';
            }
        }) 
        ->addColumn('aksi', function($data){
            return view('Master.customer.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }

    public function barang()
    {
        $coba = Master_Barang::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('Master.barang.tombol')->with('data', $data);
        })
        ->make(true);
    }


}
