<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Keuangan;
use App\Models\Pegawai_Normal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // get saldo_kas from keuangan
            $saldo = Keuangan::first()->sum('saldo_kas');
            // get total money spend from Pengeluaran Table
            $total_spend = History::where('tipe', 'pengeluaran')->sum('jumlah');
            // get total money income from Pemasukan Table
            $total_income = History::where('tipe', 'pemasukan')->sum('jumlah');

            // get all pegawai_normal
            $pegawai_normal = Pegawai_Normal::where('status', 'active')->count();
            // get all pegawai_rumahan
            $pegawai_rumahan = Pegawai_Normal::where('status', 'active')->count();
            $total_pgw = $pegawai_normal + $pegawai_rumahan;

            // prepare data for chart
            $penjualan_lain = History::selectRaw('MONTH(tanggal) as month, sum(jumlah) as total')
                ->where('keterangan', 'Penjualan Lain')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            $penjualan_jasa = History::selectRaw('MONTH(tanggal) as month, sum(jumlah) as total')
                ->where('keterangan', 'Penjualan Jasa Jarit')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Combine data for each month
            $months = range(1, 12);
            $chartData = [];

            foreach ($months as $month) {
                $penjualanLain = $penjualan_lain->where('month', $month)->first();
                $penjualanJasa = $penjualan_jasa->where('month', $month)->first();

                $chartData[] = [
                    'month' => $month,
                    'penjualan_lain' => $penjualanLain ? $penjualanLain->total : 0,
                    'penjualan_jasa' => $penjualanJasa ? $penjualanJasa->total : 0,
                ];
            }

            // prepare data pemasukan dan pengeluaran perhari for line chart
            $pemasukan = History::selectRaw('DATE(tanggal) as date, sum(jumlah) as total')
                ->where('tipe', 'pemasukan')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            $pengeluaran = History::selectRaw('DATE(tanggal) as date, sum(jumlah) as total')
                ->where('tipe', 'pengeluaran')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $lineChartData = [];
            foreach ($pemasukan as $pemasukanItem) {
                $pengeluaranItem = $pengeluaran->where('date', $pemasukanItem->date)->first();
                $lineChartData[] = [
                    'date' => $pemasukanItem->date,
                    'pemasukan' => $pemasukanItem->total,
                    'pengeluaran' => $pengeluaranItem ? $pengeluaranItem->total : 0,
                ];
            }

            // return dashboard
            return view('dashboard.index', compact(
                'total_spend', 
                'total_income', 
                'saldo', 
                'total_pgw', 
                'chartData', 
                'lineChartData'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
