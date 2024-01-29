<?php

namespace App\Http\Controllers\Master\Pengeluaran;

use App\Http\Controllers\Controller;
use App\Models\Master_Pengeluaran;
use Illuminate\Http\Request;

class GetUpdateMasterPengeluaranController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Int $id)
    {
        try {
            // get data id
            $data = Master_Pengeluaran::where('id', $id)->first();
            
            // if data empty
            if (!$data) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }

            // return data
            return response()->json([
                'result' => $data
            ], 200);
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
