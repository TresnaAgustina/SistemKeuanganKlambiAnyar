<?php

namespace App\Http\Controllers\Master\Barang;

use Illuminate\Http\Request;
use App\Models\Master_Barang;
use App\Http\Controllers\Controller;

class DeleteMasterBarangController extends Controller
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
            $data = Master_Barang::where('id', $request->id)->first();

            //if data not found
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Data Master Barang Not Found!',
                    'data' => ''
                ], 400);
            }

            //delete data from database
            $delete = Master_Barang::where('id', $request->id)->delete();

            //if delete data fails
            if (!$delete) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Delete Data Master Barang Failed!',
                    'data' => ''
                ], 400);
            }

            //return json response
            return response()->json([
                'success' => true,
                'message' => 'Delete Data Master Barang Success',
                'data' => $delete
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Delete Data Master Barang Failed!'. $e->getMessage(),
                'data' => ''
            ], 400);
        }
    }
}
