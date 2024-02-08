<?php

namespace App\Http\Controllers\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Master_Pemasukan;
use App\Models\Pemasukan;
use Illuminate\Http\Request;

class CreatePemasukanController extends Controller
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
            // get all request
            $data = $request->all();

            // check if request data is empty
            if (!$data) {
                // return response()->json([
                //     'status' => 'error',
                //     'message' => 'Request data is empty',
                // ], 400);

                // for monolith app
                return redirect()->back()->with(
                    'pesan', 'Request data is empty'
                );
            }

            // get data master_pemasukan by id_mstr_pemasukan
            $data_mstr = Master_Pemasukan::find($data['id_mstr_pemasukan']);

            // check if data_mstr is null
            if ($data_mstr == null) {
                // return response()->json([
                //     'message' => 'Data pemasukan tidak ditemukan'
                // ], 404);

                // for monolith app
                return redirect()->back()->with(
                    'pesan', 'Data pemasukan tidak ditemukan'
                );
            }

            // validation
            $validate = $request->validate([
                'id_mstr_pemasukan' => 'required|numeric',
                'tanggal' => 'required|date',
                'total' => 'required|numeric',
                'keterangan' => 'nullable|string'
            ]);

            // if validation is fails
            if (!$validate) {
                // return response()->json([
                //     'status' => 'error',
                //     'message' => $request->errors(),
                // ], 400);

                // for monolith app
                return redirect()->back()->with(
                    'pesan', 'Failed validate data'
                );
            }

            // create pemasukan
            $pemasukan = Pemasukan::create([
                'id_mstr_pemasukan' => $data['id_mstr_pemasukan'],
                'id_keuangan' => 1,
                'tanggal' => $data['tanggal'],
                'total' => $data['total'],
                'keterangan' => $data['keterangan'],
            ]);

            // if create pemasukan is fails
            if (!$pemasukan) {
                // return response()->json([
                //     'status' => 'error',
                //     'message' => $pemasukan->errors(),
                // ], 400);

                // for monolith app
                return redirect()->back()->with(
                    'pesan', $pemasukan->errors()
                );
            }

            // return json response
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Success: Success to create pemasukan',
            //     'data' => [
            //             'id' => $pemasukan->id,
            //             'id_mstr_pemasukan' => $pemasukan->id_mstr_pemasukan,
            //             'nama_atribut' => $data_mstr->nama_atribut,
            //             'tanggal' => $pemasukan->tanggal,
            //             'total' => $pemasukan->total,
            //             'keterangan' => $pemasukan->keterangan,
            //         ],
            // ], 200);

            // for monolith app
            return redirect()->back()->with(
                'success', 'Success create data'
            );
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Error: '.$e->getMessage(),
            // ], 400);

            // for monolith app
            return redirect()->back()->with(
                'error', 'Error:' . $e->getMessage()
            );
        }
    }
}
