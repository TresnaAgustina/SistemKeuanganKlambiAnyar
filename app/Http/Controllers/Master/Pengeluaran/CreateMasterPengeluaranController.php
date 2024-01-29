<?php

namespace App\Http\Controllers\Master\Pengeluaran;

use Illuminate\Http\Request;
use App\Models\Master_Pengeluaran;
use App\Http\Controllers\Controller;

class CreateMasterPengeluaranController extends Controller
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

            // validation
            $validate = $request->validate([
                'nama_atribut' => 'required|string|max:150|unique:master_pengeluaran,nama_atribut',
                'tipe' => 'required|in:1,2',
            ]);

            // if validation fails
            if (!$validate) {
                // return response()->json([
                //     'status' => 'error',
                //     'message' => 'Data gagal ditambahkan',
                //     'data' => Null
                // ], 400);

                // for monolith app
                return redirect()->back()->with(
                    'pesan', 'Error: Data gagal ditambahkan'
                );
            }

            // create data
            $create = Master_Pengeluaran::create([
                'nama_atribut' => $data['nama_atribut'],
                'tipe' => $data['tipe'],
            ]);

            // if create fails
            if (!$create) {
                // return response()->json([
                //     'status' => 'error',
                //     'message' => 'Data gagal ditambahkan',
                //     'data' => Null
                // ], 400);

                // for monolith app
                return redirect()->back()->with(
                    'pesan', 'Error: Data gagal ditambahkan'
                );
            }

            // return data
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Data berhasil ditambahkan',
            //     'data' => $create
            // ], 200);

            // for monolith app
            return redirect()->back()->with(
                'success', 'Data berhasil ditambahkan'
            );

        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Data gagal ditambahkan',
            //     'data' => $e->getMessage()
            // ], 500);

            // for monolith app
            return redirect()->back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
