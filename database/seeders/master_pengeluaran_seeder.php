<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class master_pengeluaran_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create master pengeluaran
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Pembelian Kain Tunai',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Pembelian Kain Kredit',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Pembayaran Kain Kredit',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Pembelian Kebutuhan Jarit',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Ongkos Kirim',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Pembelian Minyak Pertamax',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Alat Tulis Kantor (ATK)',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Servis Mesin',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Peralatan Mesin',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Inventaris Mesin',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Listrik, PDAM, Internet',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Air Minum Karyawan - Aqua Galon',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Pembelian Beras - Karyawan',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Biaya Makan - Karyawan',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Gaji/Ongkos Jarit',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Upakara',
            'tipe' => 'perusahaan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \App\Models\master_pengeluaran::create([
            'nama_atribut' => 'Listrik, PDAM, Internet - Pribadi',
            'tipe' => 'pribadi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
