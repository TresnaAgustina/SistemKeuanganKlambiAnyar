<?php

namespace App\Http\Controllers\Keuangan;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CreateKeuanganController extends Controller
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
            //get data from request
            $data = $request->all();

            //validate data
            $validator = Validator::make($data, [
                'nama_atribut' => 'required|string|max:150',
                'tipe' => 'required|in:1,2',
                'jumlah' => 'required|numeric',
            ]);

            //if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 400);

                // for monolith app
                // return redirect()->back()->withErrors(
                //     'Error: '.$validator
                // );
            }

            //create data
            $data = Keuangan::create([
                'nama_atribut' => $data['nama_atribut'],
                'tipe' => $data['tipe'],
                'jumlah' => $data['jumlah'],
            ]);

            // if fails
            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data gagal ditambahkan',
                ], 500);

                // for monolith app
                // return redirect()->back()->withErrors(
                //     'Error: Data gagal ditambahkan'
                // );
            }

            //if validation success
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan',
                'data' => $data,
            ], 200);

            // for monolith app
            // return redirect()->back()->withSuccess(
            //     'Data berhasil ditambahkan'
            // );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal ditambahkan',
                'error' => $e->getMessage(),
            ], 500);

            // for monolith app
            // return redirect()->back()->withErrors(
            //     'Error: '.$e->getMessage()
            // );
        }
    }
}
