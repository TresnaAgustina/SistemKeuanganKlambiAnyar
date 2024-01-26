<?php

namespace App\Http\Controllers;

use App\Models\Master_Jaritan;
use App\Models\Master_Pemasukan;
use App\Models\Master_Pengeluaran;
use Illuminate\Http\Request;

class OrakOrekController extends Controller
{
    public function jaritan($id)
    {
       $data = Master_Jaritan::where('id', $id)->first();
       return response()->json(['result' => $data]);
    }
    
    public function editJaritan(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required',
            'hargaDalam' => 'required',
            'hargaLuar' => 'required',
        ]);

        $data =[
            'jenis_jaritan' => $request->jenis,
            'harga_dalam' => $request->hargaDalam,
            'harga_luar' => $request->hargaLuar,
        ];

        Master_Jaritan::where('id', $id)->update($data);

        return response()->json(['success' => "data berhasil melakukan update data"]);
    }

    public function pemasukan($id)
    {
       $data = Master_Pemasukan::where('id', $id)->first();
       return response()->json(['result' => $data]);
    }
    
    public function editPemasukan(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $data =[
            'nama_atribut' => $request->nama,
        ];

        Master_Pemasukan::where('id', $id)->update($data);

        return response()->json(['success' => "data berhasil melakukan update data"]);
    }

    public function pengeluaran($id)
    {
       $data = Master_Pengeluaran::where('id', $id)->first();
       return response()->json(['result' => $data]);
    }
    
    public function editPengeluaran(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
        ]);

        $data =[
            'nama_atribut' => $request->nama,
            'tipe' => $request->tipe,
        ];

        Master_Pengeluaran::where('id', $id)->update($data);

        return response()->json(['success' => "data berhasil melakukan update data"]);
    }
}
