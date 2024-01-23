<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchPengeluaranController extends Controller
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
            //get request dta
            $data = $request->all();

            //if request data is empty
            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Request data is empty',
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Request data is empty'
                // );
            }

            //get data by search
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
                ->where('master_pengeluaran.nama_atribut', 'like', '%' . $data['search'] . '%')
                ->orWhere('pengeluaran.tanggal', 'like', '%' . $data['search'] . '%')
                ->orWhere('pengeluaran.metode_pembayaran', 'like', '%' . $data['search'] . '%')
                ->orWhere('pengeluaran.subtotal', 'like', '%' . $data['search'] . '%')
                ->orWhere('pengeluaran.keterangan', 'like', '%' . $data['search'] . '%')
                ->get();

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
            // )->withData($data);

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
