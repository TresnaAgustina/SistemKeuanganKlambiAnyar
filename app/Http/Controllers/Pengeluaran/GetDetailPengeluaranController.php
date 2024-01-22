<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetDetailPengeluaranController extends Controller
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
            //get data by id
            $data = Pengeluaran::join('master_pengeluaran', 'pengeluaran.id_mstr_pengeluaran', '=', 'master_pengeluaran.id')
                ->select(
                    'pengeluaran.id',
                    'pengeluaran.id_mstr_pengeluaran',
                    'master_pengeluaran.nama_atribut',
                    'pengeluaran.tanggal',
                    'pengeluaran.metode_pembayaran',
                    'pengeluaran.subtotal',
                    'pengeluaran.keterangan',
                    'pengeluaran.bukti_pembayaran',
                )
                ->where('pengeluaran.id', $request->id)
                ->first();

            //if data is empty
            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data not found',
                ], 404);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Data not found'
                // );
            }

            //if data is success
            return response()->json([
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Data found'
            // );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);

            // for monolith app
            // return redirect()->back()->with(
            //     'error', $e->getMessage()
            // );
        }
    }
}
