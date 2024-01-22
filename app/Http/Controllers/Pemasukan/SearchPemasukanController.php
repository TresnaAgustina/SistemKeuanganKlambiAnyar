<?php

namespace App\Http\Controllers\Pemasukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchPemasukanController extends Controller
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
            //get request
            $data = $request->all();

            // get data by keyword
            $pemasukan = Pemasukan::where('id_mstr_pemasukan', 'like', '%' . $data['keyword'] . '%')
                ->orWhere('tanggal', 'like', '%' . $data['keyword'] . '%')
                ->orWhere('total', 'like', '%' . $data['keyword'] . '%')
                ->orWhere('keterangan', 'like', '%' . $data['keyword'] . '%')
                ->get();

            // if data not found, return success response but data is null
            if (!$pemasukan) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data not found',
                    'data' => Null
                ], 200);

                // for monolith app
                // return redirect()->back()->with(
                //     'success', 'Data not found'
                // );
            }

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Success get data',
                'data' => [
                    'id' => $pemasukan->id,
                    'id_mstr_pemasukan' => $pemasukan->id_mstr_pemasukan,
                    'tanggal' => $pemasukan->tanggal,
                    'total' => $pemasukan->total,
                    'keterangan' => $pemasukan->keterangan,
                ]
            ], 200);

            // for monolith app
            // return view('pemasukan.index', compact('data'));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'data' => Null
            ], 500);

            // for monolith app
            // return redirect()->back()->with(
            //     'error', 'Error: ' . $e->getMessage()
            // );
        }
    }
}
