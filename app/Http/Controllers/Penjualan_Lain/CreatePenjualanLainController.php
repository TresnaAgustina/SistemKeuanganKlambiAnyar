<?php

namespace App\Http\Controllers\Penjualan_Lain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penjualan_Lain;
use Illuminate\Support\Facades\Validator;

class CreatePenjualanLainController extends Controller
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
            //get all request data
            $data = $request->all();

            // make validation
            $validate = Validator::make($data, [
                'id_customer' => 'required|numeric',
                'tanggal' => 'required|date',
                'metode_pembayaran' => 'required|in:cash,kredit',
                'jmlh_bayar_awal' => 'nullable|numeric',
                'tgl_jatuh_tempo' => 'nullable|date',
                'jmlh_dibayar' => 'nullable|numeric',
                'keterangan' => 'nullable|string',
                'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'barang.*.id_mstr_barang' => 'required|numeric',
                'barang.*.jumlah_barang' => 'required|numeric',
                'barang.*.harga_satuan' => 'required|numeric',
                'barang.*.subtotal' => 'required|numeric',
            ]);

            // if validation fails
            if ($validate->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validate->errors()
                ], 422);
                return redirect()->back()->with('pesan', 'Data gagal divalidasi')->withErrors($validate);
            }

            // if metode pembayaran is 'cash' : jmlh_bayar_awal and tgl_jatuh_tempo must be null
            if ($data['metode_pembayaran'] == 'cash') {
                $data['jmlh_bayar_awal'] = null;
                $data['tgl_jatuh_tempo'] = null;
            }else{
                // if metode pembayaran is 'kredit' : jmlh_dibayar must be null
                $data['jmlh_dibayar'] = null;
                // set tanggal jatuh tempo 1 week from now
                $data['tgl_jatuh_tempo'] = date('Y-m-d', strtotime('+1 week'));
            }

            // generate kode penjualan (format: PL-<rand(4 anngka)>-<tanggal>)
            $kode_penjualan = 'PL-'.rand(1000, 9999).'-'.date('Ymd');

            // store bukti pembayaran to storage
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                // create file name (format: bukti_pembayaran_<kode_penjualan>_<tanggal>.<ext>)
                $filename = 'bukti_pembayaran_'.$kode_penjualan.'_'.date('Ymd').'_'.time().'.'.$file->getClientOriginalExtension();
                $file->storeAs('public/bukti_pembayaran', $filename);
                $data['bukti_pembayaran'] = $filename;
            }else{
                $data['bukti_pembayaran'] = null;
            }

            // subtotal = jumlah_barang * harga_satuan
            foreach ($data['barang'] as $key => $barang) {
                $data['barang'][$key]['subtotal'] = $barang['jumlah_barang'] * $barang['harga_satuan'];
            }

            // store data to penjualan_lain
            $penjualan_lain = Penjualan_Lain::create([
                'id_customer' => $data['id_customer'],
                'kode_penjualan' => $kode_penjualan,
                'tanggal' => $data['tanggal'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'jmlh_bayar_awal' => $data['jmlh_bayar_awal'],
                'tgl_jatuh_tempo' => $data['tgl_jatuh_tempo'],
                'jmlh_dibayar' => $data['jmlh_dibayar'],
                'keterangan' => $data['keterangan'],
                'bukti_pembayaran' => $data['bukti_pembayaran'],
            ]);

            // store data to cart_penjualan_lain
            foreach ($data['barang'] as $barang) {
                $penjualan_lain->cart_penjualan_lain()->create([
                    'id_penjualan_lain' => $penjualan_lain->id,
                    'id_mstr_barang' => $barang['id_mstr_barang'],
                    'jumlah_barang' => $barang['jumlah_barang'],
                    'harga_satuan' => $barang['harga_satuan'],
                    'subtotal' => $barang['subtotal'],
                ]);
            }

            // calculate total harga
            $total_harga = $penjualan_lain->cart_penjualan_lain()->sum('subtotal');
            // if jmlh_bayar_awal < total_harga, store to piutang
            if ($penjualan_lain->metode_pembayaran == 'kredit' && $penjualan_lain->jmlh_bayar_awal < $total_harga) {
                $piutang = $penjualan_lain->piutang()->create([
                    'id_jual_lain' => $penjualan_lain->id,
                    'id_jual_jasa' => null,
                    'jumlah_piutang' => $total_harga - $penjualan_lain->jmlh_bayar_awal,
                    // set tanggal jatuh tempo 1 week from now
                    'tgl_jatuh_tempo' => date('Y-m-d', strtotime('+1 week')),
                    'status' => 'Belum Lunas'
                ]);

                // if fails
                if (!$piutang) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Gagal membuat piutang'
                    ], 500);
                    return redirect()->back()->with('pesan', 'Gagal membuat piutang');
                }
            }

            // check if fails
            if (!$penjualan_lain || !$penjualan_lain->cart_penjualan_lain()->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal membuat penjualan lain'
                ], 500);
                return redirect()->back()->with('pesan', 'Gagal membuat penjualan lain');
            }

            // return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil membuat penjualan lain',
                'data' => $penjualan_lain,
            ], 200);
            return redirect()->back()->with('success', 'Berhasil membuat penjualan lain');

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);

            return redirect()->back()->with('pesan', $e->getMessage());
        }
    }
}
