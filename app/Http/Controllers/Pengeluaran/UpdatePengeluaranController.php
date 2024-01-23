<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\Master_Pengeluaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UpdatePengeluaranController extends Controller
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
            // get all rquest data.
            $data = $request->all();

            // if request data is empty.
            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Request data is empty',
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Request data is empty'
                // );
            }

            // find by id.
            $pengeluaran = Pengeluaran::findOrFail($request->id);

            // get nama_atribut from master_pengeluaran.
            $nama_atribut = Master_Pengeluaran::find($data['id_mstr_pengeluaran']);

            // if nama_atribut is null.
            if (!$nama_atribut) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data master pengeluaran not found',
                ], 404);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Data master pengeluaran not found'
                // );
            }

            // validate request data.
            $validator = Validator::make($data, [
                'id_mstr_pengeluaran' => 'required|numeric|exists:master_pengeluaran,id',
                'tanggal' => 'required|date',
                'metode_pembayaran' => 'required|in:1,2',
                'subtotal' => 'required|numeric',
                'keterangan' => 'nullable|string',
                'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            // check if validator is fails.
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

            // update image and unlink old image.
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $filename = time() . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
                $file->move('storage/pengeluaran', $filename);
                $data['bukti_pembayaran'] = $filename;

                // unlink old image.
                if ($pengeluaran->bukti_pembayaran) {
                    unlink('storage/pengeluaran/' . $pengeluaran->bukti_pembayaran);
                }
            }

            // update data.
            $update = $pengeluaran->update([
                'id_mstr_pengeluaran' => $data['id_mstr_pengeluaran'],
                'tanggal' => $data['tanggal'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'subtotal' => $data['subtotal'],
                'keterangan' => $data['keterangan'],
                'bukti_pembayaran' => $data['bukti_pembayaran'],
            ]);

            // check if update is success.
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

            // if update is success.
            return response()->json([
                'status' => 'success',
                'message' => 'Data updated',
                'data' => $pengeluaran
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Data updated'
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
