<?php

namespace App\Http\Controllers\Master\Pegawai\Pegawai_Rumahan;

use App\Http\Controllers\Controller;
use App\Models\Pegawai_Normal;
use App\Models\Pegawai_Rumahan;
use Illuminate\Http\Request;

class DeletePgwrRumahanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Int $id)
    {
        try {
            
            // get data by id
            $pegawai = Pegawai_Rumahan::where('id', $id);

            // if data not found
            if (!$pegawai) {
                return redirect()->back()->with('pesan', 'Error: Data pegawai tidak tersedia');
            }

            // delete data
            $delete = Pegawai_Rumahan::where('id', $id)->delete();

            // if delete fails
            if (!$delete){
                return redirect()->back()->with('pesan', 'Error: Gagal menghapus data pegawai');
            }

            return redirect()->back()->with('success', 'Success: Berhasil menghapus data pegawai');
        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', 'Error: ' . $e->getMessage());
        }
    }
}
