<?php

namespace App\Http\Controllers\Piutang;

use App\Models\History;
use App\Models\Piutang;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdatePiutangController extends Controller
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
            //get data piutang by id
            $piutang = Piutang::find($request->id);

            // if not found, return error
            if (!$piutang) {
                return redirect()->back()->with('pesan', 'Data piutang tidak ditemukan');
            }

            // validate request
           $request->validate([
                'jumlah_bayar' => 'nullable|numeric',
            ]);

            if (!empty($request->jumlah_bayar)) {
                $jumlah = str_replace(['.'], '',$request->jumlah_bayar);
            } else {
                $jumlah = null;
            }

            // if jumlah bayar > sisa piutang, return error
            if ($jumlah > $piutang->sisa_piutang) {
                return redirect()->back()->with('pesan', 'Jumlah bayar melebihi sisa piutang');
            }

            // jika jumlah bayar tidak kosong, maka update sisa piutang, jika kosong maka tidak perlu update sisa piutang
            if ($jumlah) {
                if ($jumlah > $piutang->sisa_piutang) {
                    return redirect()->back()->with('pesan', 'Jumlah bayar melebihi sisa piutang');
                }

                // update sisa piutang
                $sisa_piutang = $piutang->sisa_piutang - $jumlah;

                // update saldo_kas in keuangan
                $keuangan = Keuangan::first();
                $keuangan->update([
                    'saldo_kas' => $keuangan->saldo_kas + $jumlah
                ]);

                if ($piutang->id_jual_lain){
                    $keterangan = 'Pelunasan piutang - ' . $piutang->penjualan_lain->customer->nama_customer;
                }else{
                    $keterangan = 'Pelunasan piutang - ' . $piutang->penjualan_jasa_jarit->customer->nama_customer;
                }

                // store to history
                History::create([
                    'keterangan' => $keterangan,
                    'tipe' => 'Pemasukan',
                    'jumlah' => $jumlah,
                    // set tanggan to today
                    'tanggal' => date('Y-m-d')
                    ]);
            }else{
                $sisa_piutang = $piutang->sisa_piutang;
            }

            if($sisa_piutang == 0){
                $status = 'Lunas';
            }else{
                $status = $request->status;
            }

            // update data piutang
            $piutang->update([
                'id_jual_lain' => $piutang->id_jual_lain,
                'id_jual_jasa' => $piutang->id_jual_jasa,
                'jumlah_bayar' => $jumlah,
                'jumlah_piutang' => $piutang->jumlah_piutang,
                'tgl_jatuh_tempo' => $piutang->tgl_jatuh_tempo,
                'sisa_piutang' => $sisa_piutang,
                'status' => $status
            ]);

            // if fails
            if (!$piutang) {
                return redirect()->back()->with('pesan', 'Gagal update piutang');
            }

            return redirect()->back()->with('pesan', 'Berhasil update piutang');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);

            return redirect()->back()->with('pesan', $e->getMessage());
        }
    }
}
