<?php

namespace App\Http\Controllers\Penjualan_Lain;

use App\Models\History;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Models\Master_Barang;
use App\Models\Penjualan_Lain;
use App\Http\Controllers\Controller;
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

            // *** make validation *** //
            $validate = Validator::make($data, [
                'id_customer' => 'required|numeric',
                'tanggal' => 'required|date',
                'metode_pembayaran' => 'required|in:cash,credit',
                'jmlh_bayar_awal' => 'nullable|numeric',
                'tgl_jatuh_tempo' => 'nullable|date',
                'jmlh_dibayar' => 'nullable|numeric',
                'keterangan' => 'nullable|string',
                'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'barang.*.id_mstr_barang' => 'required|numeric',
                'barang.*.jumlah_barang' => 'required|numeric',
            ]);

            if (!empty($data['jmlh_bayar_awal'])) {
                $credit = str_replace(['.'], '', $data['jmlh_bayar_awal']);
            } else {
                $credit = null;
            }
            
            if (!empty($data['jmlh_dibayar'])) {
                $cash = str_replace(['.'], '', $data['jmlh_dibayar']);
            } else {
                $cash = null;
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
            if ($data['metode_pembayaran'] == 'cash' && $cash < array_sum(array_column($data['barang'], 'subtotal'))) {
                return redirect()->back()->with('pesan', 'Jumlah dibayar tidak mencukupi');
            }
            if($data['metode_pembayaran'] == 'credit' && $credit > array_sum(array_column($data['barang'], 'subtotal'))){
                return redirect()->back()->with('pesan', 'Jumlah bayar awal melebihi total harga');
            }

            // generate kode penjualan (format: PL-<rand(4 anngka)>-<tanggal>)
            $kode_penjualan = 'PL-'.rand(1000, 9999).'-'.date('Ymd');

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

            // *** STORE PROCESS *** //
            // store data to penjualan_lain
            $penjualan_lain = Penjualan_Lain::create([
                'id_customer' => $data['id_customer'],
                'kode_penjualan' => $kode_penjualan,
                'tanggal' => $data['tanggal'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'jmlh_bayar_awal' => $credit,
                'tgl_jatuh_tempo' => $data['tgl_jatuh_tempo'],
                'jmlh_dibayar' => $cash,
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

            // update saldo_kas in keuangan, tambah dengan jmlh_bayar_awal atau jmlh_dibayar
            $keuangan = Keuangan::first();
            if ($penjualan_lain->metode_pembayaran == 'cash') {
                $keuangan->update([
                    'saldo_kas' => $keuangan->saldo_kas + $penjualan_lain->jmlh_dibayar
                ]);
            }else if($penjualan_lain->metode_pembayaran == 'credit'){
                $keuangan->update([
                    'saldo_kas' => $keuangan->saldo_kas + $penjualan_lain->jmlh_bayar_awal
                ]);
            }

            // calculate total harga
            $total_harga = $penjualan_lain->cart_penjualan_lain()->sum('subtotal');
            // if jmlh_bayar_awal < total_harga, store to piutang
            if ($penjualan_lain->metode_pembayaran == 'credit' && $penjualan_lain->jmlh_bayar_awal < $total_harga) {
                $piutang = $penjualan_lain->piutang()->create([
                    'id_jual_lain' => $penjualan_lain->id,
                    'id_jual_jasa' => null,
                    // jumlah_bayar = untuk update piutang ketika pelunasan
                    'jumlah_bayar' => null,
                    'jumlah_piutang' => $total_harga - $penjualan_lain->jmlh_bayar_awal,
                    // set tanggal jatuh tempo 1 week from now
                    'tgl_jatuh_tempo' => date('Y-m-d', strtotime('+1 week')),
                    'sisa_piutang' => $total_harga - $penjualan_lain->jmlh_bayar_awal,
                    'status' => 'Belum Lunas'
                ]);

                // if fails
                if (!$piutang) {
                    return redirect()->back()->with('pesan', 'Gagal membuat piutang');
                }
            }

            // insert to histories
            $history = History::create([
                'keterangan' => 'Penjualan Lain',
                'tipe' => 'Pemasukan',
                'jumlah' => $penjualan_lain->metode_pembayaran == 'cash' ? $penjualan_lain->jmlh_dibayar : $penjualan_lain->jmlh_bayar_awal,
                'tanggal' => $penjualan_lain->tanggal,
            ]);
            

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
