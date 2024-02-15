<?php

namespace App\Http\Controllers\Hutang;

use App\Http\Controllers\Controller;
use App\Models\Hutang;
use Illuminate\Http\Request;

class GetUpdateHutangController extends Controller
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
            $data = Hutang::where('id', $id)->first();
            
            // if data empty
            if (!$data) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }

            return view('transaksi.hutang.bayar')->with([
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
