<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DeletePengeluaranController extends Controller
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
            //get dta by id
            $data = Pengeluaran::findOrFail($request->id);

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

            //delete data and unlink image from storage/pengeluaran
            Storage::delete('public/pengeluaran/' . $data->bukti_pembayaran);
            $data->delete();

            //if delete data and unlink image is fails
            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Delete data is failed',
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Delete data is failed'
                // );
            }

            //if delete data and unlink image is success
            return response()->json([
                'status' => 'success',
                'message' => 'Delete data is success',
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Delete data is success'
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
