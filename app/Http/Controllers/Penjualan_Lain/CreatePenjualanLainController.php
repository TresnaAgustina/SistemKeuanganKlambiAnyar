<?php

namespace App\Http\Controllers\Penjualan_Lain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penjualan_Lain;
use Illuminate\Support\Facades\Validator;

class CreatePenjualanLainController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('transaksi.penjualan.index');
    }
}