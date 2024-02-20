<?php

namespace App\Http\Controllers\Penjualan_Jasa_Jarit;

use App\Models\History;
use App\Models\Piutang;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Models\Master_Jaritan;
use App\Models\CartPenjualanJasa;
use App\Http\Controllers\Controller;
use App\Models\Penjualan_Jasa_Jarit;
use Illuminate\Support\Facades\Validator;

class CreatePenjualanJasaJaritController extends Controller
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

            //make validation
            $validate = Validator::make($data, [
                'id_customer' => 'required|numeric',
                'tanggal' => 'required|date',
                'metode_pembayaran' => 'required|in:cash,credit',
                'jmlh_bayar_awal' => 'nullable',
                'tgl_jatuh_tempo' => 'nullable|date',
                'jmlh_dibayar' => 'nullable',
                'keterangan' => 'nullable|string',
                'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'barang.*.id_mstr_jaritan' => 'required|numeric',
                'barang.*.jumlah_barang' => 'required|numeric',
            ]);

            if (!empty($data['jmlh_bayar_awal'])) {
                $data['jmlh_bayar_awal'] = str_replace(['.', ','], '', $data['jmlh_bayar_awal']);
            } else {
                $data['jmlh_bayar_awal'] = null;
            }
            
            if (!empty($data['jmlh_dibayar'])) {
                $data['jmlh_dibayar'] = str_replace(['.', ','], '', $data['jmlh_dibayar']);
            } else {
                $data['jmlh_dibayar'] = null;
            }
            
            // ddd($data['jmlh_bayar_awal']);

            //if validation fails
            if ($validate->fails()) {
                return redirect()->back()->with('pesan', 'Error: '.$validate->errors());
            }

            //if metode pembayaran is 'cash' : jmlh_bayar_awal and tgl_jatuh_tempo must be null
            if ($data['metode_pembayaran'] == 'cash') {
                $data['jmlh_bayar_awal'] = null;
                $data['tgl_jatuh_tempo'] = null;
            } else {
                //if metode pembayaran is 'credit' : jmlh_dibayar must be null
                $data['jmlh_dibayar'] = null;
                //set tanggal jatuh tempo 1 week from now
                $data['tgl_jatuh_tempo'] = date('Y-m-d', strtotime('+1 week'));
            }

            // harga_satuan get from master_jaritan->harga_dalam
            foreach ($data['barang'] as $key => $value) {
                $data['barang'][$key]['harga_satuan'] = Master_Jaritan::find($value['id_mstr_jaritan'])->harga_dalam;
            }
            // subtotal in cart_jual_jasa = jumlah_barang * harga_satuan
            foreach ($data['barang'] as $key => $value) {
                $data['barang'][$key]['subtotal'] = $value['jumlah_barang'] * $value['harga_satuan'];
            }

            // chek if metode_pembayaran == 'cash' && jmlh_dibayar < total_harga, show alert
            if ($data['metode_pembayaran'] == 'cash' && $data['jmlh_dibayar'] < array_sum(array_column($data['barang'], 'subtotal'))) {
                return redirect()->back()->with('pesan', 'Jumlah dibayar tidak mencukupi');
            }
            if($data['metode_pembayaran'] == 'credit' && $data['jmlh_bayar_awal'] > array_sum(array_column($data['barang'], 'subtotal'))){
                return redirect()->back()->with('pesan', 'Jumlah bayar awal melebihi total harga');
            }

            // generate kode penjualan (format: PL-<rand(4 anngka)>-<tanggal>)
            $kode_penjualan = 'PJ-'.rand(1000, 9999).'-'.date('Ymd');

            // jika data yang diinputkan memiliki tanggal yang sama namun metode pembayaran berbeda, return eror
            $penjualan_jasa_same_date = Penjualan_Jasa_Jarit::where('tanggal', $data['tanggal'])->where('id_customer', $data['id_customer'])->where('metode_pembayaran', '!=', $data['metode_pembayaran'])->first();
            if ($penjualan_jasa_same_date) {
                return redirect()->back()->with('pesan', 'Tidak dapat membuat penjualan dengan metode pembayaran yang berbeda pada tanggal yang sama');
            }

             // store bukti pembayaran to storage
             if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                // create file name (format: bukti_pembayaran_<kode_penjualan>_<tanggal>.<ext>)
                $filename = 'bukti_pembayaran_'.$kode_penjualan.'_'.date('Ymd').'_'.time().'.'.$file->getClientOriginalExtension();
                $file->storeAs('public/Penjualan_Jasa', $filename);
                $data['bukti_pembayaran'] = $filename;
            }else{
                $data['bukti_pembayaran'] = null;
            }

            // *** STORE PROCESS *** //
            $penjualan_jasa = Penjualan_Jasa_Jarit::updateOrCreate([
                'id_customer' => $data['id_customer'],
                'tanggal' => $data['tanggal'],
            ],[
                'kode_penjualan' => $kode_penjualan,
                'metode_pembayaran' => $data['metode_pembayaran'],
                'jmlh_bayar_awal' => $data['jmlh_bayar_awal'],
                'tgl_jatuh_tempo' => $data['tgl_jatuh_tempo'],
                'jmlh_dibayar' => $data['jmlh_dibayar'],
                'keterangan' => $data['keterangan'],
                'bukti_pembayaran' => $data['bukti_pembayaran'],
            ]);

            $isRecordNewlyCreated = $penjualan_jasa->wasRecentlyCreated;

            // check if the cart is exist
            $cart = CartPenjualanJasa::where('id_penjualan_jasa', $penjualan_jasa->id)->get();
            // If the cart is not empty, update existing items or create new items
            if ($cart->isNotEmpty()) {
                foreach ($data['barang'] as $barang) {
                    $existingCartItem = $cart->where('id_mstr_jaritan', $barang['id_mstr_jaritan'])->first();

                    // If the item already exists in the cart, update it
                    if ($existingCartItem) {
                        $existingCartItem->update([
                            'jumlah_barang' => $existingCartItem->jumlah_barang + $barang['jumlah_barang'],
                            'harga_satuan' => $barang['harga_satuan'],
                            'subtotal' => $existingCartItem->subtotal + $barang['subtotal'],
                        ]);
                    } else {
                        // If the item doesn't exist in the cart, create a new one
                        $penjualan_jasa->cart_penjualan_jasa()->create([
                            'id_penjualan_jarit' => $penjualan_jasa->id,
                            'id_mstr_jaritan' => $barang['id_mstr_jaritan'],
                            'jumlah_barang' => $barang['jumlah_barang'],
                            'harga_satuan' => $barang['harga_satuan'],
                            'subtotal' => $barang['subtotal'],
                        ]);
                    }
                }
            } else {
                // If the cart is empty, create new items
                foreach ($data['barang'] as $barang) {
                    $penjualan_jasa->cart_penjualan_jasa()->create([
                        'id_penjualan_jarit' => $penjualan_jasa->id,
                        'id_mstr_jaritan' => $barang['id_mstr_jaritan'],
                        'jumlah_barang' => $barang['jumlah_barang'],
                        'harga_satuan' => $barang['harga_satuan'],
                        'subtotal' => $barang['subtotal'],
                    ]);
                }
            }

            // *** UPDATE or CREATE PIUTANG *** //
            $total_harga = $penjualan_jasa->cart_penjualan_jasa()->sum('subtotal');
            if ($penjualan_jasa->metode_pembayaran == 'credit') {
                $piutang = Piutang::updateOrCreate(
                    ['id_jual_jasa' => $penjualan_jasa->id],
                    [
                        'jumlah_piutang' => $total_harga - $penjualan_jasa->jmlh_bayar_awal,
                        'tgl_jatuh_tempo' => $penjualan_jasa->tgl_jatuh_tempo,
                        'sisa_piutang' => $total_harga - $penjualan_jasa->jmlh_bayar_awal,
                        'status' => 'Belum Lunas',
                    ]
                );
            }

            // update saldo_kas in keuangan, tambah dengan jmlh_bayar_awal atau jmlh_dibayar
            $keuangan = Keuangan::first();
            $existingPiutang = Piutang::where('id_jual_jasa', $penjualan_jasa->id)->first();
            if ($isRecordNewlyCreated) {
                if ($penjualan_jasa->metode_pembayaran == 'cash') {
                    $keuangan->update([
                        'saldo_kas' => $keuangan->saldo_kas + $penjualan_jasa->jmlh_dibayar,
                    ]);
                } elseif ($penjualan_jasa->metode_pembayaran == 'credit') {
                    // Check if there's an existing Piutang record
                    if ($existingPiutang) {
                        // Get the existing jmlh_bayar_awal from the Piutang record
                        $existingJmlhBayarAwal = $existingPiutang->jumlah_bayar_awal;
            
                        // Check if the new jmlh_bayar_awal is greater than the existing one
                        if ($penjualan_jasa->jmlh_bayar_awal > $existingJmlhBayarAwal) {
                            // Calculate the difference in jmlh_bayar_awal
                            $difference = $penjualan_jasa->jmlh_bayar_awal - $existingJmlhBayarAwal;
            
                            // Update saldo_kas in keuangan with the difference
                            $keuangan->update([
                                'saldo_kas' => $keuangan->saldo_kas + $difference,
                            ]);
                        }
                    } else {
                        // If there's no existing Piutang, update saldo_kas with the new jmlh_bayar_awal
                        $keuangan->update([
                            'saldo_kas' => $keuangan->saldo_kas + $penjualan_jasa->jmlh_bayar_awal,
                        ]);
                    }
                }
            }

            // insert to histories only if the record is newly created
            if ($isRecordNewlyCreated) {
                History::create([
                    'keterangan' => 'Penjualan Jasa Jarit',
                    'tipe' => 'Pemasukan',
                    'jumlah' => $penjualan_jasa->metode_pembayaran == 'cash' ? $penjualan_jasa->jmlh_dibayar : $penjualan_jasa->jmlh_bayar_awal,
                    'tanggal' => $penjualan_jasa->tanggal,
                ]);
            }

            return redirect()->back()->with('success', 'Berhasil membuat penjualan');

        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', $e->getMessage());
        }
    }
}
