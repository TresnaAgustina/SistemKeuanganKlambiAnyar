<?php

namespace App\Http\Controllers\DataTable;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Master_Customer;
use App\Models\Pengeluaran;

class TableLaporanController extends Controller
{
    public function DataPemasukan(Request $request){
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $coba = Pemasukan::select(['id_mstr_pemasukan', 'metode_pembayaran', 'tanggal', 'total', 'keterangan', 'created_at'])
        ->when($tanggalMulai && $tanggalAkhir, function ($query) use ($tanggalMulai, $tanggalAkhir) {
            return $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })
        ->orderBy('tanggal', 'desc')
        ->get();

        // $coba = Pemasukan::orderBy('id', 'asc');

        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->master_pemasukan->nama_atribut;
         })
        ->addColumn('total', function($data){
            if ($data->total) {
                return 'Rp. '. number_format($data->total) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->make(true);
    }
    public function DataPengeluaran(Request $request){
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $coba = Pengeluaran::select(['id_mstr_pengeluaran', 'metode_pembayaran', 'tanggal', 'subtotal', 'keterangan', 'created_at'])
        ->when($tanggalMulai && $tanggalAkhir, function ($query) use ($tanggalMulai, $tanggalAkhir) {
            return $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })
        ->orderBy('tanggal', 'desc')
        ->get();

        // $coba = Pemasukan::orderBy('id', 'asc');

        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->master_pengeluaran->nama_atribut;
         })
        ->addColumn('total', function($data){
            if ($data->subtotal) {
                return 'Rp. '. number_format($data->subtotal) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->make(true);
    }
    public function pajak(Request $request){
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $coba = Master_Customer::select(['nama_customer', 'alamat_customer', 'no_telp_customer', 'created_at'])
        ->when($tanggalMulai && $tanggalAkhir, function ($query) use ($tanggalMulai, $tanggalAkhir) {
            return $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })
        ->orderBy('tanggal', 'desc')
        ->get();

        // $coba = Pemasukan::orderBy('id', 'asc');

        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->master_pengeluaran->nama_atribut;
         })
        ->addColumn('total', function($data){
            if ($data->subtotal) {
                return 'Rp. '. number_format($data->subtotal) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->make(true);
    }
}
