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
            if($piutang){
                $totalPiutang = $piutang->sum('sisa_piutang');
            }else{
                $totalPiutang = 0;
            }

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
