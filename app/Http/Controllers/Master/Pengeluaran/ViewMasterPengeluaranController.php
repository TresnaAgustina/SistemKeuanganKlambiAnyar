<?php

namespace App\Http\Controllers\Master\Pengeluaran;

use App\Http\Controllers\Controller;
use App\Models\Master_Pengeluaran;
use Illuminate\Http\Request;

class ViewMasterPengeluaranController extends Controller
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
            //get data from database
            $data = Master_Pengeluaran::all();

            //return data
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Data berhasil diambil',
            //     'data' => $data
            // ], 200);

            // for monolith app
            return view('Master.pengeluaran.index')->with([
                'data' => $data
            ]);
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Data gagal diambil',
            //     'data' => $e->getMessage()
            // ], 500);

            // for monolith app
            return view('dashboard')->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
