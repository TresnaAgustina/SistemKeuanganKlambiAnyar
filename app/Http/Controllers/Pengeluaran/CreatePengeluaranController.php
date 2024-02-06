<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Models\Keuangan;
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
                return redirect()->back()->with(
                    'pesan', 'Request data is empty'
                );
            }

            // get data master_pengeluaran by id_mstr_pengeluaran
            $mstr_pengeluaran = Master_Pengeluaran::find($data['id_mstr_pengeluaran']);

            // if data master_pengeluaran is null
            if (!$mstr_pengeluaran) {
                return redirect()->back()->with(
                    'pesan', 'Data master pengeluaran not found'
                );
            }

            // validate request data
            $validator = Validator::make($data, [
                'id_mstr_pengeluaran' => 'required|numeric|exists:master_pengeluaran,id',
                'tanggal' => 'required|date',
                'metode_pembayaran' => 'required|enum:cash,transfer|in:cash,credit',
                'total' => 'required|numeric',
                'keterangan' => 'nullable|string',
                'bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            // if validation is fails
            if (!$validator) {
                return redirect()->back()->with(
                    'pesan', 'Failed validate data'
                );
            }

            // upload image
            $image = $request->file('bukti');
            // make image name with timestamp format with detail time like year, month, day, hour, minute, and second
            $image_name = 'pengeluaran_'. time() . '_' . date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/pengeluaran'), $image_name);

            // if upload image is fails
            if (!$image) {
                return redirect()->back()->with(
                    'pesan', 'Failed upload image'
                );
            }

            // check if total > saldo_kas in keuangan
            $keuangan = Keuangan::first();
            if ($keuangan->saldo_kas < $data['total']){
                return redirect()->back()->with(
                    'pesan', 'Saldo Tidak mencukupi'
                );
            }

            // create pengeluaran
            $pengeluaran = \App\Models\Pengeluaran::create([
                'id_mstr_pengeluaran' => $data['id_mstr_pengeluaran'],
                'tanggal' => $data['tanggal'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'subtotal' => $data['total'],
                'keterangan' => $data['keterangan'],
                'bukti_pembayaran' => $image_name
            ]);

            // update saldo_kas in keuangan
            if ($pengeluaran->metode_pembayaran == 'cash') {
                $keuangan->update([
                    'saldo_kas' => $keuangan->saldo_kas - $pengeluaran->subtotal
                ]);
            }else if($pengeluaran->metode_pembayaran == 'credit'){
                $keuangan->update([
                    'saldo_kas' => $keuangan->saldo_kas - $pengeluaran->subtotal
                ]);
            }

            // if create pengeluaran is fails
            if (!$pengeluaran) {
                return redirect()->back()->with(
                    'pesan', 'Failed create pengeluaran'
                );
            }

            // return response
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Success create pengeluaran',
            //     'data' => [
            //         'id' => $pengeluaran->id,
            //         'id_mstr_pengeluaran' => $pengeluaran->id_mstr_pengeluaran,
            //         'nama_atribut' => $mstr_pengeluaran->nama_atribut,
            //         'tanggal' => $pengeluaran->tanggal,
            //         'metode_pembayaran' => $pengeluaran->metode_pembayaran,
            //         'subtotal' => $pengeluaran->subtotal,
            //         'keterangan' => $pengeluaran->keterangan,
            //         'bukti_pembayaran' => $pengeluaran->bukti_pembayaran,
            //     ]
            // ], 200);

            // for monolith app
            return redirect()->back()->with(
                'success', 'Success create pengeluaran'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'pesan', $e->getMessage()
            );
        }
    }
}
