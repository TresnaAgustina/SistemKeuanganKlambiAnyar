<?php

namespace App\Http\Controllers\Master\Pengeluaran;

use Illuminate\Http\Request;
use App\Models\Master_Pengeluaran;
use App\Http\Controllers\Controller;

class DeleteMasterPengeluaranController extends Controller
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
            //find data by id
            $find = Master_Pengeluaran::where('id', $request->id)->first();

            //if data not found
            if (!$find) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                    'data' => Null
                ], 404);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Data tidak ditemukan'
                // );
            }

            //delete data
            $delete = Master_Pengeluaran::where('id', $request->id)->delete();

            //if delete fails
            if (!$delete) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data gagal dihapus',
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Data gagal dihapus'
                // );
            }

            //return success message
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
                'data' => Null
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Data berhasil dihapus'
            // );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
