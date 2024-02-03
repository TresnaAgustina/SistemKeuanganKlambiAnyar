<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class HitungController extends Controller
{
    public function saldoBank(Request $request){

        $item = $request->validate([
            'jumlah' => 'required',
            'tanggal' => 'required'
        ]);

       // Ambil data tabungan
       $keuangan = Keuangan::first();
       $jumlah = str_replace(['.'], '', $item['jumlah']);


       if($keuangan){
         // Lakukan isi saldo
         $keuangan->saldo_bank = ($keuangan->saldo_bank ?? 0) + $jumlah;
         $keuangan->save();

         // Tambahkan data penarikan
         History::create([
             'keterangan' => $request->keterangan,
             'tipe' => $request->tipe,
             'jumlah' => $jumlah,
             'tanggal' => $item['tanggal'],
         ]);

         return redirect()->to('keuangan/all')->with([
             'success' => 'berhasil melakukan isi saldo',
         ]);

        
        }else{
        
             // Tambahkan data keuangan
             Keuangan::create([
                'saldo_bank' => $jumlah,
                'saldo_kas' => 0
            ]);

            // Tambahkan data history
            History::create([
                'keterangan' => $request->keterangan,
                'tipe' => $request->tipe,
                'jumlah' => $jumlah,
                'tanggal' => $item['tanggal'],
            ]);

            return redirect()->to('keuangan/all')->with([
                'success' => ' berhasil melakukan isi saldo',
            ]);
        }
    }
    public function saldoKas(Request $request){

        $item = $request->validate([
            'jumlah' => 'required',
            'tanggal' => 'required'
        ]);

       // Ambil data tabungan
       $keuangan = Keuangan::find(1);
       $jumlah = str_replace(['.'], '', $item['jumlah']);

       if(!$keuangan){

            // Tambahkan data keuangan
            Keuangan::create([
                'saldo_bank' => 0,
                'saldo_kas' => $jumlah
            ]);

            // Tambahkan data history
            History::create([
                'keterangan' => $request->keterangan,
                'tipe' => $request->tipe,
                'jumlah' => $jumlah,
                'tanggal' => $item['tanggal'],
            ]);

            return redirect()->to('keuangan/all')->with([
                'success' => ' berhasil melakukan isi saldo',
            ]);

        }else{
             // Lakukan isi saldo
            $keuangan->saldo_kas = ($keuangan->saldo_kas ?? 0) + $jumlah;
            $keuangan->save();

            // Tambahkan data penarikan
            History::create([
                'keterangan' => $request->keterangan,
                'tipe' => $request->tipe,
                'jumlah' => $jumlah,
                'tanggal' => $item['tanggal'],
            ]);

            return redirect()->to('keuangan/all')->with([
                'success' => 'berhasil melakukan isi saldo',
            ]);
        }
    }

    public function trfBank(Request $request){

        $item = $request->validate([
            'jumlah' => 'required',
            'tanggal' => 'required'
        ]);

       // Ambil data tabungan
       $keuangan = Keuangan::find(1);
       $jumlah = str_replace(['.'], '', $item['jumlah']);

       if($keuangan){
        if($keuangan->saldo_bank >= $jumlah){
             // Lakukan penarikan dan kurangi saldo
            $keuangan->saldo_bank = ($keuangan->saldo_bank ?? 0) - $jumlah;
            $keuangan->saldo_kas = ($keuangan->saldo_kas ?? 0) + $jumlah;
            $keuangan->save();

            // Tambahkan data penarikan
            History::create([
                'keterangan' => $request->keterangan,
                'tipe' => $request->tipe,
                'jumlah' => $jumlah,
                'tanggal' => $item['tanggal'],
            ]);

            return redirect()->to('keuangan/all')->with([
                'success' => ' berhasil melakukan transfer',
            ]);

        }else{
            return redirect()->to('keuangan/all')->with('error', 'Saldo tidak mencukupi untuk transfer');
        }
        }else{
            return redirect()->to('keuangan/all')->with('error', 'Saldo tidak mencukupi untuk transfer');
        }
    }
    
    public function trfKas(Request $request){

        $item = $request->validate([
            'jumlah' => 'required',
            'tanggal' => 'required'
        ]);

       // Ambil data tabungan
       $keuangan = Keuangan::find(1);
       $jumlah = str_replace(['.'], '', $item['jumlah']);

       if($keuangan){
        if($keuangan->saldo_kas >= $jumlah){
            // Lakukan penarikan dan kurangi saldo
            $keuangan->saldo_bank = ($keuangan->saldo_bank ?? 0) + $jumlah;
            $keuangan->saldo_kas = ($keuangan->saldo_kas ?? 0) - $jumlah;
            $keuangan->save();

            // Tambahkan data penarikan
            History::create([
                'keterangan' => $request->keterangan,
                'tipe' => $request->tipe,
                'jumlah' => $jumlah,
                'tanggal' => $item['tanggal'],
            ]);
            return redirect()->to('keuangan/all')->with([
                'success' => ' berhasil melakukan transfer',
            ]);

        }else{
            return redirect()->to('keuangan/all')->with('error', 'Saldo tidak mencukupi untuk transfer');
        }
        }else{
            return redirect()->to('keuangan/all')->with('error', 'Saldo tidak mencukupi untuk transfer');
        }
    }

}
