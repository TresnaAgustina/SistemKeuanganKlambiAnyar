<?php

namespace App\Http\Controllers\Hutang;

use App\Http\Controllers\Controller;
use App\Models\Hutang;
use App\Models\Master_Pengeluaran;
use Illuminate\Http\Request;

class GetAllHutangController extends Controller
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
            $data = Hutang::all();
            $pengeluaran = Master_Pengeluaran::all();

            // if data is empty
            if (!$data) {
                // return response()->json([
                //     'status' => 'error',
                //     'message' => 'Data not found',
                // ], 404);

                // for monolith app
                return redirect()->back()->with(
                    'error', 'Data not found'
                );
            }
            if($data){
                $totalHutang = $data->sum('sisa_hutang');
            }else{
                $totalHutang = 0;
            }

            // if data is success
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Data found',
            //     'data' => $data
            // ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Data found'
            // );
            return view('transaksi.hutang.index')->with([
                'data' => $data,
                'pengeluaran' => $pengeluaran,
                'hutang' => $totalHutang
            ]);

        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => $e->getMessage(),
            // ], 500);

            // for monolith app
            return redirect()->back()->with(
                'error', $e->getMessage()
            );
        }
    }
}
