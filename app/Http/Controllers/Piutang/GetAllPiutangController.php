<?php

namespace App\Http\Controllers\Piutang;

use App\Http\Controllers\Controller;
use App\Models\Piutang;
use Illuminate\Http\Request;

class GetAllPiutangController extends Controller
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

            $piutang = Piutang::all();

            // get nama customer from penjualan_lain
            // $piutang = Piutang::join('penjualan_lain', 'piutang.id_jualan_lain', '=', 'penjualan_lain.id')
            //     ->join('customer', 'penjualan_lain.id_customer', '=', 'customer.id')
            //     ->select(
            //         'piutang.id',
            //         'piutang.id_jualan_lain',
            //         'penjualan_lain.id_customer',
            //         'customer.nama as nama_customer',
            //         'piutang.tanggal',
            //         'piutang.total',
            //         'piutang.sisa_piutang',
            //         'piutang.keterangan',
            //     )
            //     ->get();

            if($piutang){
                $totalPiutang = $piutang->sum('sisa_piutang');
            }else{
                $totalPiutang = 0;
            }

            // return response()->json([
            //     'status' => 'success',
            //     'data' => $piutang1
            // ], 200);

            return view('transaksi.piutang.index')->with([
                'piutang' => $totalPiutang,
            ]);

            // return response
            // return response()->json([
            //     'status' => 'success',
            //     'data' => $penjualan_lain
            // ], 200);
            
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'pesan' => $e->getMessage()
            // ], 500);
            return back()->with('pesan', $e->getMessage());
        }
       
    }
}
