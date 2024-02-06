<?php

namespace App\Http\Controllers\Penjualan_Lain;

use App\Http\Controllers\Controller;
use App\Models\Penjualan_Lain;
use Illuminate\Http\Request;

class GetAllPenjualanLainController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            // get all data from table
            $data = Penjualan_Lain::all();

            return view('penjualan.penjualan-lain.index')->with([
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Get All Data Master Barang Failed!'. $e->getMessage(),
                'data' => ''
            ], 400);

            return back()->with('pesan', $e->getMessage());
        }
    }
}
