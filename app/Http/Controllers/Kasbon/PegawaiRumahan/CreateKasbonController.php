<?php

namespace App\Http\Controllers\Kasbon\PegawaiRumahan;

use App\Models\History;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Models\KasbonPgwTetap;
use App\Models\Pegawai_Rumahan;
use App\Models\KasbonPgwRumahan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CreateKasbonController extends Controller
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
            //get all data request
            $data = $request->all();


            // get data pgw_rumahan by_id
            $pgw = Pegawai_Rumahan::find($data['id_pgw_rumahan']);

            // if data pegawai not found
            if (!$pgw) {
                return redirect()->back()->with(
                    'pesan', 'Error: Data Pegawai Rumahan Tidak Ditemukan'
                );
            }

            // validation data request
            $validate = Validator::make($data, [
                'id_pgw_rumahan' => 'required|exist:pegawai_rumahan, id',
                'tanggal' => 'required|date',
                'jumlah_kasbon' => 'nullable|numeric',
            ]);

            // if validate fails
            if (!$validate) {
                return redirect()->back()->with(
                    'pesan', 'Error: '. $validate->errors()
                );
            }

            // create status to Belum Lunas
            $status = "Belum Lunas";
            // sisa kasbon
            $sisa = $data['jumlah_kasbon'];

            // check if saldo_kas < jumlah_kasbon
            $saldo = Keuangan::first();
            if ($saldo->saldo_kas < $data['jumlah_kasbon']) {
                return redirect()->back()->with(
                    'pesan', 'Saldo Kas Tidak Mencukupi, Isi Saldo Terlebih Dahulu'
                );
            }

            // if data kasbon with id_pgw_normal is exists, then update the sisa kasbon
            $kasbon = KasbonPgwRumahan::where('id_pgw_rumahan', $data['id_pgw_rumahan'])->first();
            if ($kasbon) {
                if ($kasbon->status == 'belum lunas'){
                    $kasbon->update([
                        'jumlah_kasbon' => $kasbon->jumlah_kasbon + $data['jumlah_kasbon'],
                        'sisa' => $kasbon->sisa + $data['jumlah_kasbon'],
                    ]);
                }else{
                    $kasbon->update([
                        'jumlah_kasbon' => $data['jumlah_kasbon'],
                        'sisa' => $data['jumlah_kasbon'],
                        'status' => $status,
                    ]);
                }
                
            }else{
                // if doesn't exists, create new data kasbon
                $store = KasbonPgwRumahan::create([
                    'id_pgw_rumahan' => $data['id_pgw_rumahan'],
                    'tanggal' => $data['tanggal'],
                    'jumlah_kasbon' => $data['jumlah_kasbon'],
                    'sisa' => $sisa,
                    'status' => $status,
                ]);

                // check if store is fails
                if (!$store) {
                    return redirect()->back()->with(
                        'pesan', 'Error: Gagal Menyimpan Data Kasbon'
                    );
                }
            }

            // update data saldo_kas
            $saldo->update([
                'saldo_kas' => $saldo->saldo_kas - $data['jumlah_kasbon']
            ]);

            // update history tipe pengeluaran
            History::create([
                'tanggal' => $data['tanggal'],
                'keterangan' => 'Kasbon Pegawai Rumahan',
                'tipe' => 'Pengeluaran',
                'jumlah' => $data['jumlah_kasbon'],
            ]);

            // return success
            return redirect()->back()->with(
                'success', 'Berhasil Menyimpan Data Kasbon'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'pesan', "Error: ". $e->getMessage()
            );
        }
    }
}
