<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanPajakController extends Controller
{
    public function index(){
        return view('laporan.laporan-pajak.index');
    }
}
