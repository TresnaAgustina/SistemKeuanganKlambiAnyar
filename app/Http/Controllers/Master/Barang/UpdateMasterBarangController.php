<?php

namespace App\Http\Controllers\Master\Barang;

use Illuminate\Http\Request;
use App\Models\Master_Barang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UpdateMasterBarangController extends Controller
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
            //get all data request
            $data = $request->all();

            $check = Master_Barang::where('id', $id)->first();

            //if data not found
            if (!$check) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Data Master Barang Not Found!',
                    'data' => ''
                ], 404);
            }

            // aku komen karena waktu tak coba dia malah tambah data, buka update
            //validate request data
            $validate = Validator::make($data, [
                'nama_barang' => 'required|string|unique:master_barang,nama_barang',
                'harga_beli' => 'required|numeric',
                'harga_jual' => 'required|numeric',
            ]);

            if (!$validate) {
                return back()->with(
                    'pesan', 'Error: ' . $request->errors()
                );
            }

            //update data to database
            $update = Master_Barang::where('id', $request->id)->update([
                'nama_barang' => $data['nama_barang'],
                'harga_beli' => $data['harga_beli'],
                'harga_jual' => $data['harga_jual'],
            ]);

            if (!$update) {
                return back()->with(
                    'pesan', 'Error: Failed to update data to database'
                );
            }

            //return data
         
            return back()->with('success', 'Update Data Master Barang Success');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Update Data Master Barang Failed!'. $e->getMessage(),
                'data' => ''
            ], 400);
        }
    }
}
