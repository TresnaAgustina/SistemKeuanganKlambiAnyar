<?php

namespace App\Http\Controllers\Kasbon\PegawaiRumahan;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Models\KasbonPgwRumahan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BayarKasbonController extends Controller
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

            // get data kasbon by id
            $kasbon = KasbonPgwRumahan::find($data['id'])->first();

            // if data kasbon not found
            if (!$kasbon) {
                return redirect()->to('kasbon-rumahan/all')->with(
                    'pesan', 'Error: Data Kasbon Tidak Ditemukan'
                );
            }

            // validation data request
            $validate = Validator::make($data, [
                'tanggal' => 'required|date',
                'jumlah_bayar' => 'nullable|numeric',
            ]);

            // if validate fails
            if (!$validate) {
                return redirect()->to('kasbon-rumahan/all')->with(
                    'pesan', 'Error: '. $validate->errors()
                );
            }

            // if jumlah bayar > sisa kasbon
            if ($data['jumlah_bayar'] > $kasbon->sisa) {
                return redirect()->to('kasbon-rumahan/all')->with(
                    'pesan', 'Error: Jumlah Bayar Melebihi Sisa Kasbon'
                );
            }

            // update sisa kasbon
            $kasbon->sisa = $kasbon->sisa - $data['jumlah_bayar'];
            $kasbon->save();

            // update status kasbon jika sisa = 0
            if ($kasbon->sisa == 0) {
                $kasbon->status = "Lunas";
                $kasbon->save();
            }

            // update saldo kas
            $saldo = Keuangan::first();
            $saldo->saldo_kas = $saldo->saldo_kas + $data['jumlah_bayar'];

            // return success message
            return redirect()->to('kasbon-rumahan/all')->with(
                'success', 'Berhasil Bayar Kasbon'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'pesan', 'Error: '. $e->getMessage()
            );
        }
    }
}
