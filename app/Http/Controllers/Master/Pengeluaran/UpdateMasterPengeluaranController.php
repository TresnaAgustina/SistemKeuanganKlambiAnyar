<?php

namespace App\Http\Controllers\Master\Pengeluaran;

use App\Http\Controllers\Controller;
use App\Models\Master_Pengeluaran;
use Illuminate\Http\Request;

class UpdateMasterPengeluaranController extends Controller
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
            //get all request
            $data = $request->all();

            // find data by id
            $find = Master_Pengeluaran::where('id', $request->id)->first();

            // if data not found
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

            // validation
            $validate = $request->validate([
                'nama_atribut' => 'required|string|max:150|unique:master_pengeluaran,nama_atribut,' . $request->id,
                'tipe' => 'required|in:1,2',
            ]);

            // if validation fails
            if (!$validate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data gagal diubah',
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Data gagal diubah'
                // );
            }

            // update data
            $update = $find->update([
                'nama_atribut' => $data['nama_atribut'],
                'tipe' => $data['tipe'],
            ]);

            // if update fails
            if (!$update) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data gagal diubah',
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Data gagal diubah'
                // );
            }

            // return data
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diubah',
                'data' => [
                    'id' => $find->id,
                    'nama_atribut' => $data['nama_atribut'],
                    'tipe' => $data['tipe'],
                ]
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Data berhasil diubah'
            // );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal diubah',
                'data' => $e->getMessage()
            ], 500);

            // for monolith app
            // return redirect()->back()->with(
            //     'error', $e->getMessage()
            // );
        }
    }
}
