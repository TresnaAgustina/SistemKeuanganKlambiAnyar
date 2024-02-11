<?php

namespace App\Http\Controllers\Piutang;

use App\Http\Controllers\Controller;
use App\Models\Piutang;
use Illuminate\Http\Request;

class GetUpdatePiutangController extends Controller
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
            // get data id
            $data = Piutang::where('id', $id)->first();
            
            // if data empty
            if (!$data) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }

            return view('transaksi.piutang.bayar')->with([
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
