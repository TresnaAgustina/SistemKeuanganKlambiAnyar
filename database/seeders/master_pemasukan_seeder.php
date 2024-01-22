<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class master_pemasukan_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create master pemasukan
        \App\Models\master_pemasukan::create([
            'nama_atribut' => 'Penjualan Tunai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pemasukan::create([
            'nama_atribut' => 'Penjualan Kredit/Bon',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pemasukan::create([
            'nama_atribut' => 'Pembayaran Kredit/Bon',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pemasukan::create([
            'nama_atribut' => 'Bank',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pemasukan::create([
            'nama_atribut' => 'Tabungan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pemasukan::create([
            'nama_atribut' => 'Piutang Karyawan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pemasukan::create([
            'nama_atribut' => 'Pembayaran Utang Karyawan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
