<?php

namespace App\Http\Controllers\Hutang;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class CreateHutangController extends Controller
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

            // validation
            $validator = \Validator::make($data, [
                'id_pengeluaran' => 'required|exists:pengeluaran,id',
                'jumlah_hutang' => 'required|numeric',
                'tgl_jatuh_tempo' => 'required|date',
                'sisa_hutang' => 'required|numeric',
                'status' => 'required|in:Lunas,Belum Lunas',
            ]);

            if ($validator->fails()) {
                return redirect()->with('pesan', 'Error: '. $validator->errors());
            }

            //create hutang
            $hutang = \App\Models\Hutang::create([
                'id_pengeluaran' => $data['id_pengeluaran'],
                'jumlah_hutang' => $data['jumlah_hutang'],
                'tgl_jatuh_tempo' => $data['tgl_jatuh_tempo'],
                'sisa_hutang' => $data['sisa_hutang'],
                'status' => $data['status'],
            ]);

            // if jumlah_bayar is not null, update saldo kas in keuangan
            if ($data['jumlah_bayar'] != null) {
                $keuangan = Keuangan::where('id', 1)->first();
                $keuangan->saldo_kas = $keuangan->saldo_kas - $data['jumlah_bayar'];
                $keuangan->save();
            }

            // if jumlah_bayat is not null, store to history
            if ($data['jumlah_bayar'] != null) {
                History::create([
                    'tipe' => 'Pengeluaran',
                    'jumlah' => $data['jumlah_bayar'],
                    'keterangan' => 'Pembayaran hutang',
                    'tanggal' => date('Y-m-d'),
                ]);
            }

            // if store hutang is fails
            if (!$hutang) {
                return redirect()->back()->with('pesan', 'Hutang gagal dibuat');
            }

            //return hutang
            return redirect()->back()->with('success', 'Hutang berhasil dibuat');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', 'Error: ' . $e->getMessage());
        }
    }
}
