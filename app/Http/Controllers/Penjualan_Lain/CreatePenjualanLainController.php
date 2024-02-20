<?php

namespace App\Http\Controllers\Penjualan_Lain;

use App\Models\History;
use App\Models\Piutang;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Models\Master_Barang;
use App\Models\Penjualan_Lain;
use App\Http\Controllers\Controller;
use App\Models\CartPenjualanLain;
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
            // *** get all request data *** //
            $data = $request->all();
            $keuangan = Keuangan::get();

            // *** make validation *** //
            $validate = Validator::make($data, [
                'id_customer' => 'required|numeric',
                'tanggal' => 'required|date',
                'metode_pembayaran' => 'required|in:cash,credit',
                'jmlh_bayar_awal' => 'nullable',
                'tgl_jatuh_tempo' => 'nullable|date',
                'jmlh_dibayar' => 'nullable',
                'keterangan' => 'nullable|string',
                'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'barang.*.id_mstr_barang' => 'required|numeric',
                'barang.*.jumlah_barang' => 'required|numeric',
            ]);

            if (!empty($data['jmlh_bayar_awal'])) {
                $data['jmlh_bayar_awal'] = str_replace(['.'], '', $data['jmlh_bayar_awal']);
            } else {
                $data['jmlh_bayar_awal'] = null;
            }
            
            if (!empty($data['jmlh_dibayar'])) {
                $data['jmlh_dibayar'] = str_replace(['.'], '', $data['jmlh_dibayar']);
            } else {
                $data['jmlh_dibayar'] = null;
            }

            // if validation fails
            if ($validate->fails()){
                return redirect()->back()->with('pesan', 'Error: '.$validate->errors());
            }

            // *** CONFIGURATION *** //
            // if metode pembayaran is 'cash' : jmlh_bayar_awal and tgl_jatuh_tempo must be null
            if ($data['metode_pembayaran'] == 'cash') {
                $data['jmlh_bayar_awal'] = null;
                $data['tgl_jatuh_tempo'] = null;
            }else{
                // if metode pembayaran is 'credit' : jmlh_dibayar must be null
                $data['jmlh_dibayar'] = null;
                // set tanggal jatuh tempo 1 week from now
                $data['tgl_jatuh_tempo'] = date('Y-m-d', strtotime('+1 week'));
            }
            
            // harga_satuan get from master_barang
            foreach ($data['barang'] as $key => $barang) {
                $data['barang'][$key]['harga_satuan'] = Master_Barang::find($barang['id_mstr_barang'])->harga_jual;
            }
            // subtotal in cart_jual_lain = jumlah_barang * harga_satuan
            foreach ($data['barang'] as $key => $barang) {
                $data['barang'][$key]['subtotal'] = $barang['jumlah_barang'] * $barang['harga_satuan'];
            }

            // chek if metode_pembayaran == 'cash' && jmlh_dibayar < total_harga, show alert
            if ($data['metode_pembayaran'] == 'cash' && $data['jmlh_dibayar'] < array_sum(array_column($data['barang'], 'subtotal'))) {
                return redirect()->back()->with('pesan', 'Jumlah dibayar tidak mencukupi');
            }
            if($data['metode_pembayaran'] == 'credit' && $data['jmlh_bayar_awal'] > array_sum(array_column($data['barang'], 'subtotal'))){
                return redirect()->back()->with('pesan', 'Jumlah bayar awal melebihi total harga');
            }

            // jika data yang diinputkan memiliki tanggal yang sama namun metode pembayaran berbeda, maka return error
            $penjualan_lain_same_date = Penjualan_Lain::where('tanggal', $data['tanggal'])->where('id_customer', $data['id_customer'])->where('metode_pembayaran', '!=', $data['metode_pembayaran'])->get();
            foreach ($penjualan_lain_same_date as $penjualan) {
                if ($penjualan->metode_pembayaran != $data['metode_pembayaran']) {
                    return redirect()->back()->with('pesan', 'Tidak dapat membuat penjualan dengan metode pembayaran yang berbeda pada tanggal yang sama');
                }
            }

            // generate kode penjualan (format: PL-<rand(4 anngka)>-<tanggal>)
            $kode_penjualan = 'PL-'.rand(100, 999).'-'.date('Ymd');

           // store bukti pembayaran to storage
           if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                // create file name (format: bukti_pembayaran_<kode_penjualan>_<tanggal>.<ext>)
                $filename = 'bukti_pembayaran_'.$kode_penjualan.'_'.date('Ymd').'_'.time().'.'.$file->getClientOriginalExtension();
                $file->storeAs('public/Penjualan_Lain', $filename);
            $data['bukti_pembayaran'] = $filename;
            }else{
                $data['bukti_pembayaran'] = null;
            }

            // *** STORE DATA *** //
            $penjualan_lain = Penjualan_Lain::updateOrCreate([
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

            // check if the record is newly created
            $isRecordNewlyCreated = $penjualan_lain->wasRecentlyCreated;

            // // Check if the cart exists
            $cart = CartPenjualanLain::where('id_penjualan_lain', $penjualan_lain->id)->get();
            // If the cart is not empty, update existing items or create new items
            if ($cart->isNotEmpty()) {
                foreach ($data['barang'] as $barang) {
                    $existingCartItem = $cart->where('id_mstr_barang', $barang['id_mstr_barang'])->first();

                    // If the item already exists in the cart, update it
                    if ($existingCartItem) {
                        $existingCartItem->update([
                            'jumlah_barang' => $existingCartItem->jumlah_barang + $barang['jumlah_barang'],
                            'harga_satuan' => $barang['harga_satuan'],
                            'subtotal' => $existingCartItem->subtotal + $barang['subtotal'],
                        ]);
                    } else {
                        // If the item doesn't exist in the cart, create a new one
                        $penjualan_lain->cart_penjualan_lain()->create([
                            'id_penjualan_lain' => $penjualan_lain->id,
                            'id_mstr_barang' => $barang['id_mstr_barang'],
                            'jumlah_barang' => $barang['jumlah_barang'],
                            'harga_satuan' => $barang['harga_satuan'],
                            'subtotal' => $barang['subtotal'],
                        ]);
                    }
                }
            } else {
                // If the cart is empty, create new items
                foreach ($data['barang'] as $barang) {
                    $penjualan_lain->cart_penjualan_lain()->create([
                        'id_penjualan_lain' => $penjualan_lain->id,
                        'id_mstr_barang' => $barang['id_mstr_barang'],
                        'jumlah_barang' => $barang['jumlah_barang'],
                        'harga_satuan' => $barang['harga_satuan'],
                        'subtotal' => $barang['subtotal'],
                    ]);
                }
            }

            // *** UPDATE or CREATE PIUTANG *** //
            $total_harga = $penjualan_lain->cart_penjualan_lain()->sum('subtotal');
            if ($penjualan_lain->metode_pembayaran == 'credit') {
                $piutang = Piutang::updateOrCreate([
                    'id_jual_lain' => $penjualan_lain->id,
                ],[
                    'jumlah_piutang' => $total_harga - $data['jmlh_bayar_awal'],
                    'tgl_jatuh_tempo' => $data['tgl_jatuh_tempo'],
                    'sisa_piutang' => $total_harga - $data['jmlh_bayar_awal'],
                    'status' => 'Belum Lunas',
                ]);
            }
            // update saldo_kas in keuangan, tambah dengan jmlh_bayar_awal atau jmlh_dibayar
            $keuangan = Keuangan::first();
            $existingPiutang = Piutang::where('id_jual_lain', $penjualan_lain->id)->first();
            if ($isRecordNewlyCreated) {
                if ($penjualan_lain->metode_pembayaran == 'cash') {
                    $keuangan->update([
                        'saldo_kas' => $keuangan->saldo_kas + $penjualan_lain->jmlh_dibayar,
                    ]);
                } elseif ($penjualan_lain->metode_pembayaran == 'credit') {
                    // Check if there's an existing Piutang record
                    if ($existingPiutang) {
                        // Get the existing jmlh_bayar_awal from the Piutang record
                        $existingJmlhBayarAwal = $existingPiutang->jumlah_bayar_awal;
            
                        // Check if the new jmlh_bayar_awal is greater than the existing one
                        if ($penjualan_lain->jmlh_bayar_awal > $existingJmlhBayarAwal) {
                            // Calculate the difference in jmlh_bayar_awal
                            $difference = $penjualan_lain->jmlh_bayar_awal - $existingJmlhBayarAwal;
            
                            // Update saldo_kas in keuangan with the difference
                            $keuangan->update([
                                'saldo_kas' => $keuangan->saldo_kas + $difference,
                            ]);
                        }
                    } else {
                        // If there's no existing Piutang, update saldo_kas with the new jmlh_bayar_awal
                        $keuangan->update([
                            'saldo_kas' => $keuangan->saldo_kas + $penjualan_lain->jmlh_bayar_awal,
                        ]);
                    }
                }
            }

            // insert to histories only if the record is newly created
            if ($isRecordNewlyCreated) {
                History::create([
                    'keterangan' => 'Penjualan Lain',
                    'tipe' => 'Pemasukan',
                    'jumlah' => $penjualan_lain->metode_pembayaran == 'cash' ? $penjualan_lain->jmlh_dibayar : $penjualan_lain->jmlh_bayar_awal,
                    'tanggal' => $penjualan_lain->tanggal,
                ]);
            }
            

            // check if fails
            if (!$penjualan_lain || !$penjualan_lain->cart_penjualan_lain()->exists()) {
                return redirect()->back()->with('pesan', 'Gagal membuat penjualan');
            }

            return redirect()->back()->with('success', 'Berhasil membuat penjualan');

        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', $e->getMessage());
        }
    }
}
