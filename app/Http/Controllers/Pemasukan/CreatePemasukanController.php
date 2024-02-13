<?php

namespace App\Http\Controllers\Pemasukan;

use App\Models\History;
use App\Models\Keuangan;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Models\Master_Pemasukan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CreatePemasukanController extends Controller
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

            //if request data is empty
            if (!$data) {
                return redirect()->back()->with(
                    'pesan', 'Request data is empty'
                );
            }

            //get data master_pemasukan by id_mstr_pemasukan
            $mstr_pemasukan = Master_Pemasukan::find($data['id_mstr_pemasukan']);

            //if data master_pemasukan is null
            if (!$mstr_pemasukan) {
                return redirect()->back()->with(
                    'pesan', 'Data master pemasukan not found'
                );
            }

            // validate request data
            $validator = Validator::make($data, [
                'id_mstr_pemasukan' => 'required|numeric|exists:master_pemasukan,id',
                'tanggal' => 'required|date',
                'metode_pembayaran' => 'required|in:cash,credit',
                'total' => 'required|numeric',
                'keterangan' => 'nullable|string',
                'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            if (!empty($data['total'])) {
                $total = str_replace(['.'], '', $data['total']);
            } else {
                $total = null;
            }

            //if validation is fails
            if ($validator->fails()) {
                return redirect()->back()->with(
                    'pesan', $validator->errors()->first()
                );
            }

            //if request has file bukti_pembayaran
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                // create file name (format: bukti_pembayaran_<kode_penjualan>_<tanggal>.<ext>)
                $filename = 'pemasukan'.'_'.date('Ymd').'_'.time().'.'.$file->getClientOriginalExtension();
                $file->storeAs('public/pemasukan', $filename);
                $data['bukti_pembayaran'] = $filename;
            }else{
                $data['bukti_pembayaran'] = null;
            }

            //create pemasukan
            $pemasukan = Pemasukan::create([
                'id_mstr_pemasukan' => $data['id_mstr_pemasukan'],
                'tanggal' => $data['tanggal'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'total' => $total,
                'keterangan' => $data['keterangan'],
                'bukti_pembayaran' => $data['bukti_pembayaran']
            ]);            

            // update saldo_kas in keuangan
            $keuangan = Keuangan::first();
            $keuangan->update([
                'saldo_kas' => $keuangan->saldo_kas + $total
            ]);

            // store to history
            History::create([
                'keterangan' => $pemasukan->master_pemasukan->nama_atribut,
                'tipe' => 'Pemasukan',
                'jumlah' => $total,
                // set tanggan to today
                'tanggal' => date('Y-m-d')
            ]);


            // if create fails
            if (!$pemasukan) {
                return redirect()->back()->with(
                    'pesan', 'Failed create pemasukan'
                );
            }

            // redirect to pemasukan index

            return redirect()->back()->with(
                'success', 'Success create pemasukan'
            );
            
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'pesan', $e->getMessage()
            );
        }
    }
}