<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanPemasukanController extends Controller
{
    public function index(){
        return view('laporan.laporan-pemasukan.index');
    }

    
}
