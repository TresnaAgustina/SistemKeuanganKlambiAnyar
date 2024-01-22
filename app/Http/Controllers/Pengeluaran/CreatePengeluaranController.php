<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\Master_Pengeluaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CreatePengeluaranController extends Controller
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

            // if request data is empty
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

            // get data master_pengeluaran by id_mstr_pengeluaran
            $mstr_pengeluaran = Master_Pengeluaran::find($data['id_mstr_pengeluaran']);

            // if data master_pengeluaran is null
            if (!$mstr_pengeluaran) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pengeluaran not found',
                ], 404);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Data master pengeluaran not found'
                // );
            }

            // validate request data
            $validator = Validator::make($data, [
                'id_mstr_pengeluaran' => 'required|numeric|exists:master_pengeluaran,id',
                'tanggal' => 'required|date',
                'metode_pembayaran' => 'required|enum:cash,transfer|in:1,2',
                'subtotal' => 'required|numeric',
                'keterangan' => 'nullable|string',
                'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            // if validation is fails
            if (!$validator) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Failed validate data'
                // );
            }

            // upload image
            $image = $request->file('bukti_pembayaran');
            // make image name with timestamp format with detail time like year, month, day, hour, minute, and second
            $image_name = time() . '_' . date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/pengeluaran'), $image_name);

            // if upload image is fails
            if (!$image) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed upload image',
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Failed upload image'
                // );
            }

            // create pengeluaran
            $pengeluaran = \App\Models\Pengeluaran::create([
                'id_mstr_pengeluaran' => $data['id_mstr_pengeluaran'],
                'tanggal' => $data['tanggal'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'subtotal' => $data['subtotal'],
                'keterangan' => $data['keterangan'],
                'bukti_pembayaran' => $image_name
            ]);

            // if create pengeluaran is fails
            if (!$pengeluaran) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed create pengeluaran',
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Failed create pengeluaran'
                // );
            }

            // get the 

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Success create pengeluaran',
                'data' => [
                    'id' => $pengeluaran->id,
                    'id_mstr_pengeluaran' => $pengeluaran->id_mstr_pengeluaran,
                    'nama_atribut' => $mstr_pengeluaran->nama_atribut,
                    'tanggal' => $pengeluaran->tanggal,
                    'metode_pembayaran' => $pengeluaran->metode_pembayaran,
                    'subtotal' => $pengeluaran->subtotal,
                    'keterangan' => $pengeluaran->keterangan,
                    'bukti_pembayaran' => $pengeluaran->bukti_pembayaran,
                ]
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Success create pengeluaran'
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
