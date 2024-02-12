<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Penjualan_Jasa_Jarit;
use App\Models\Penjualan_Lain;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index (){
        // get total money spend from Pengeluaran Table
        $total_spend = History::where('tipe', 'pengeluaran');
        // get total money income from Pemasukan Table
        $total_income = History::where('tipe', 'pemasukan');
        // return dashboard
        return view('dashboard.index');
    }
}
