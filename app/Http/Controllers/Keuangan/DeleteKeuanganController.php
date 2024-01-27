<?php

namespace App\Http\Controllers\Keuangan;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteKeuanganController extends Controller
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
            //get data keuangan by id
            $keuangan = Keuangan::find($request->id);

            // cek if data keuangan is exist
            if (!$keuangan) {
                return response()->json([
                    'message' => 'Error: Data keuangan tidak ditemukan'
                ], 404);

                // return redirect()->back()->with(
                //     'error', 'Data keuangan tidak ditemukan'
                // );
            }

            // delete data keuangan
            $delete = $keuangan->delete();

            // cek if delete success
            if (!$delete) {
                return response()->json([
                    'message' => 'Error: Delete data keuangan gagal'
                ], 400);

                // return redirect()->back()->with(
                //     'error', 'Delete data keuangan gagal'
                // );
            }

            // return success message
            return response()->json([
                'message' => 'Berhasil menghapus data keuangan'
            ], 200);

            // return redirect()->back()->with(
            //     'success', 'Berhasil menghapus data keuangan'
            // );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);

            // return redirect()->back()->with(
            //     'error', 'Error: ' . $e->getMessage()
            // );
        }
    }
}
