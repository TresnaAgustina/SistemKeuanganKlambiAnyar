<?php

namespace App\Http\Controllers\Pemasukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdatePemasukanController extends Controller
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

            // find by id
            $pemasukan = Pemasukan::findOrFail($data['id']);

            // validate request
            $validator = Validator::make($data, [
                'id_mstr_pemasukan' => 'required|exists:master_pemasukan,id',
                'tanggal' => 'required|date',
                'total' => 'required|numeric',
                'keterangan' => 'nullable|string',
            ]);

            // check if validator is fails
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $validator->errors()->first(),
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Error: ' . $validator->errors()->first()
                // );
            }

            // update data
            $update = $pemasukan->update([
                'id_mstr_pemasukan' => $data['id_mstr_pemasukan'],
                'tanggal' => $data['tanggal'],
                'total' => $data['total'],
                'keterangan' => $data['keterangan'],
            ]);

            // check if update is success
            if (!$update) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: Failed to update data',
                    'data' => Null
                ], 500);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Error: Failed to update data'
                // );
            }

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Success update data',
                'data' => [
                    'id' => $pemasukan->id,
                    'id_mstr_pemasukan' => $pemasukan->id_mstr_pemasukan,
                    'tanggal' => $pemasukan->tanggal,
                    'total' => $pemasukan->total,
                    'keterangan' => $pemasukan->keterangan,
                ]
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //    'success', 'Success update data'
            //);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'data' => Null
            ], 500);

            // for monolith app
            // return redirect()->back()->with(
            //     'error', 'Error: ' . $e->getMessage()
            // );
        }
    }
}
