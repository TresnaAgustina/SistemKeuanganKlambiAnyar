<?php

namespace App\Http\Controllers\Keuangan;

use App\Models\Keuangan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UpdateKeuanganController extends Controller
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
            //get all  data request
            $data = $request->all();

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

            // validate data request
            $validator = Validator::make($data, [
                'nama_atribut' => 'required'|'string'|'max:255',
                'tipe' => 'required'|'in:1,2',
                'jumlah' => 'required'|'numeric',
            ]);

            // update data keuangan
            $update = $keuangan->update([
                'nama_atribut' => $data['nama_atribut'],
                'tipe' => $data['tipe'],
                'jumlah' => $data['jumlah'],
            ]);

            // cek if update success
            if (!$update) {
                return response()->json([
                    'message' => 'Error: Update data keuangan gagal'
                ], 400);

                // return redirect()->back()->with(
                //     'error', 'Update data keuangan gagal'
                // );
            }

            // return success response
            return response()->json([
                'message' => 'Success: Update data keuangan berhasil',
                'data' => $keuangan
            ], 200);

            // return redirect()->back()->with(
            //     'success', 'Update data keuangan berhasil'
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
