<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Master_Customer;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Master_Barang;
use App\Models\Master_Jaritan;
use App\Models\Master_Pemasukan;
use App\Models\Master_Pengeluaran;
use App\Models\Pegawai_Normal;
use App\Models\Pegawai_Rumahan;

class DataMasterController extends Controller
{
    public function MasterCustomer(){
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

    public function MasterPegawaiTetap(){
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

    public function MasterPegawaiRumahan(){
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

    public function MasterBarang(){
        $coba = Master_Barang::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('harga beli', function($data){
            if ($data->harga_beli) {
                return 'Rp. '. number_format($data->harga_beli) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('harga jual', function($data){
            if ($data->harga_jual) {
                return 'Rp. '. number_format($data->harga_jual) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('aksi', function($data){
            return view('Master.barang.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function MasterJaritan(){
        $coba = Master_Jaritan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('harga dalam', function($data){
            if ($data->harga_dalam) {
                return 'Rp. '. number_format($data->harga_dalam) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('harga luar', function($data){
            if ($data->harga_luar) {
                return 'Rp. '. number_format($data->harga_luar) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('aksi', function($data){
            return view('master.jaritan.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function MasterPemasukan(){
        $coba = Master_Pemasukan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('master.pemasukan.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function MasterPengeluaran(){
        $coba = Master_Pengeluaran::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('master.pengeluaran.tombol')->with('data', $data);
        })
        ->make(true);
    }
}
