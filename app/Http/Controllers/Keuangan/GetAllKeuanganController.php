<?php

namespace App\Http\Controllers\Keuangan;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetAllKeuanganController extends Controller
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
            //get all data keuangan
            $keuangan = Keuangan::all();

            // return data
            // return response()->json([
            //     'message' => 'Berhasil mendapatkan semua data keuangan',
            //     'data' => $keuangan
            // ], 200);

            return view('transaksi.keuangan.index', compact('keuangan'));


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
