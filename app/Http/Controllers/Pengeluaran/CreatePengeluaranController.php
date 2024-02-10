<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Models\Hutang;
use App\Models\History;
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
                'metode_pembayaran' => 'required|in:cash,credit',
                'total' => 'required|numeric',
                'keterangan' => 'nullable|string',
                'bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            if (!empty($data['total'])) {
                $total = str_replace(['.'], '', $data['total']);
            } else {
                $total = null;
            }
        
            // if validation is fails
            if (!$validator) {
                return redirect()->back()->with(
                    'pesan', 'Failed validate data'
                );
            }

            // if request has file bukti, simpan ke public storage - pengeluaran
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                // create file name (format: bukti_pembayaran_<kode_penjualan>_<tanggal>.<ext>)
                $filename = 'pengeluaran'.'_'.date('Ymd').'_'.time().'.'.$file->getClientOriginalExtension();
                $file->storeAs('public/pengeluaran', $filename);
                $data['bukti'] = $filename;
            }else{
                $data['bukti'] = null;
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
                'subtotal' =>$total,
                'keterangan' => $data['keterangan'],
                'bukti_pembayaran' => $data['bukti']
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

            // store to history
            $history = \App\Models\History::create([
                'keterangan' => $pengeluaran->master_pengeluaran->nama_atritut,
                'tipe' => 'pengeluaran',
                'jumlah' => $pengeluaran->subtotal,
                'tanggal' => date('Y-m-d'),
            ]);

            // if metode_pembayaran is 'credit' then store data to Hutang
            if ($pengeluaran->metode_pembayaran == 'credit') {
                $hutang = Hutang::create([
                    'id_pengeluaran' => $pengeluaran->id,
                    'jumlah_hutang' => $pengeluaran->subtotal,
                    'tgl_jatuh_tempo' => $pengeluaran->tanggal,
                    'jumlah_bayar' => null,
                    'sisa_hutang' => $pengeluaran->subtotal,
                    'status' => 'Belum Lunas',
                ]);
            }

            // if create pengeluaran is fails
            if (!$pengeluaran) {
                return redirect()->back()->with(
                    'pesan', 'Failed create pengeluaran'
                );
            }

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
