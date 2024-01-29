<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class CreatePenjualanController extends Controller
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
            // get data from request
            $data = $request->all();

            // validate
            $validator = \Validator::make($data, [
                'id_mstr_jaritan' => 'required|exists:master_pengeluaran,id',
                'tanggal' => 'required|date',
                'nama_pembeli' => 'required|string',
                'no_telp' => 'required|string',
                'metode_pembayaran' => 'required|in:1,2',
                'jmlh_bayar_awal' => 'nullable|numeric',
                'subtotal' => 'nullable|numeric',
                'keterangan' => 'nullable|string',
                'bukti_pembayaran' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                    'data' => $validator->errors(),
                ], 400);
            }

            // generate kode penjualan, format: PJ(random number 6 digit)(date time)
            $kode_penjualan = 'PJ' . mt_rand(100000, 999999) . date('YmdHis');

            // check if metode pembayaran is 1 (tunai), then jmlh_bayar_awal is nullable and subtotal get from jenis jaritan - harga_dalam * quantity. get harga_dalam from master jaritan
            if ($data['metode_pembayaran'] == 1) {
                $data['jmlh_bayar_awal'] = null;
                $master_jaritan = MasterJaritan::find($data['id_mstr_jaritan']);
                $data['subtotal'] = $master_jaritan->harga_dalam * $data['quantity'];
            }else{
                $data['subtotal'] = $data['jmlh_bayar_awal'];
            }

            // create penjualan
            $penjualan = Penjualan::create([
                'id_mstr_pengeluaran' => $data['id_mstr_pengeluaran'],
                'kode_penjualan' => $kode_penjualan,
                'tanggal' => $data['tanggal'],
                'nama_pembeli' => $data['nama_pembeli'],
                'no_telp' => $data['no_telp'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'jmlh_bayar_awal' => $data['jmlh_bayar_awal'],
                'subtotal' => $data['subtotal'],
                'keterangan' => $data['keterangan'],
                'bukti_pembayaran' => $data['bukti_pembayaran'],
            ]);

            // if fails
            if (!$penjualan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create penjualan',
                ], 500);
            }

            // if success
            return response()->json([
                'status' => 'success',
                'message' => 'Success to create penjualan',
                'data' => $penjualan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create penjualan',
                'data' => $e->getMessage(),
            ], 500);
        }
    }
}
