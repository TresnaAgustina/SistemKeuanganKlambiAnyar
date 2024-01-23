<?php

namespace App\Http\Controllers\Pemasukan;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Models\Master_Pemasukan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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

            // validate request
            $validator = Validator::make($data, [
                'keyword' => 'required|string',
            ]);

            // check if validator is fails
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: ' . $validator->errors()->first(),
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Error: ' . $validator->errors()->first()
                // );
            }

            // get data by keyword
            $pemasukan = Pemasukan::where('id_mstr_pemasukan', 'like', '%' . $data['keyword'] . '%')
                ->orWhere('tanggal', 'like', '%' . $data['keyword'] . '%')
                ->orWhere('total', 'like', '%' . $data['keyword'] . '%')
                ->orWhere('keterangan', 'like', '%' . $data['keyword'] . '%')
                ->get();

            // if data not found, return success response but data is null
            if ($pemasukan->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data not found',
                    'data' => null
                ], 200);
            }

            // Loop through each item in the $pemasukan collection
            foreach ($pemasukan as $item) {
                // Find the corresponding master_pemasukan record
                $masterPemasukan = Master_Pemasukan::find($item->id_mstr_pemasukan);

                // Assign the nama_atribut property
                $item->nama_atribut = $masterPemasukan->nama_atribut;
            }

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Success get data',
                'data' => $pemasukan
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
