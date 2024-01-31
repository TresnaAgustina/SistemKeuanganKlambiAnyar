<?php

namespace App\Http\Controllers\Master\Barang;

use Illuminate\Http\Request;
use App\Models\Master_Barang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CreateMasterBarangController extends Controller
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
            // get all request data
            $data = $request->all();

            // validate request data
            $validate = Validator::make($data, [
                'nama_barang' => 'required|string|unique:master_barang,nama_barang',
                'harga_beli' => 'required|numeric',
                'harga_jual' => 'required|numeric',
            ]);

            // if validation fails
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Create Data Master Barang Failed!',
                    'data' => $validate->errors()
                ], 400);
            }

            // create data to database
            $create = Master_Barang::create([
                'nama_barang' => $data['nama_barang'],
                'harga_beli' => $data['harga_beli'],
                'harga_jual' => $data['harga_jual'],
            ]);

            // if create data fails
            // if (!$create) {
            //     return response()->json([
            //         'success' => false,
            //         'pesan' => 'Create Data Master Barang Failed!',
            //         'data' => ''
            //     ], 400);
            // }

            // // return json response
            // return response()->json([
            //     'success' => true,
            //     'pesan' => 'Create Data Master Barang Success',
            //     'data' => $create
            // ], 200);

            return back()->with('success', 'Create Data Master Barang Success');
            
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Create Data Master Barang Failed!'. $e->getMessage(),
                'data' => ''
            ], 400);

            return back()->with('pesan', $e->getMessage());
        }
    }
}
