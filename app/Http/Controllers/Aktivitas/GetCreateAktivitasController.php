<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use App\Models\Master_Jaritan;
use App\Models\Pegawai_Rumahan;
use Illuminate\Http\Request;

class GetCreateAktivitasController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $nip)
    {
        try {
            // get data id
            $data = Pegawai_Rumahan::where('nip', $nip)->first();
            $jaritan = Master_Jaritan::all();
            // if data empty
            if (!$data) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }
            // return data
            // return response()->json([
            //     'result' => $data
            // ], 200);

            return view('aktivitas.create')->with([
                'data' => $data,
                'jaritan' => $jaritan
            ]);

        //    dd($total);
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
