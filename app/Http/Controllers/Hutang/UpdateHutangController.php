<?php

namespace App\Http\Controllers\Hutang;

use App\Models\Hutang;
use App\Models\History;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateHutangController extends Controller
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
            //get data hutang by id
            $hutang = Hutang::find($request->id);

            // if not found, return error
            if (!$hutang) {
                return redirect()->back()->with('pesan', 'Data hutang tidak ditemukan');
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

            // if jumlah bayar > sisa hutang, return error
            if ($jumlah > $hutang->sisa_hutang) {
                return redirect()->back()->with('pesan', 'Jumlah bayar melebihi sisa hutang');
            }

            // jika jumlah bayar tidak kosong, maka update sisa hutang, jika kosong maka tidak perlu update sisa hutang
            if ($jumlah) {
                if ($jumlah > $hutang->sisa_hutang) {
                    return redirect()->back()->with('pesan', 'Jumlah bayar melebihi sisa hutang');
                }

                // update sisa hutang
                $sisa_hutang = $hutang->sisa_hutang - $jumlah;

                // update saldo_kas in keuangan
                $keuangan = Keuangan::first();
                $keuangan->update([
                    'saldo_kas' => $keuangan->saldo_kas - $jumlah
                ]);

                // update hutang
                $hutang->update([
                    'jumlah_bayar' => $jumlah,
                    'sisa_hutang' => $sisa_hutang,
                ]);

                // if hutang is paid off, update status to Lunas
                if ($sisa_hutang == 0) {
                    $hutang->update([
                        'status' => 'Lunas'
                    ]);
                }

                // store to history
                History::create([
                    'tipe' => 'Pengeluaran',
                    'jumlah' => $jumlah,
                    'keterangan' => 'Pembayaran hutang',
                    'tanggal' => date('Y-m-d'),
                ]);
            } 

            //return hutang
            return redirect()->to('hutang/all')->with('success', 'Hutang berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', 'Error: ' . $e->getMessage());
        }
    }
}
