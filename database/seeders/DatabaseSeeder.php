<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Keuangan;
use App\Models\ActivityItem;
use App\Models\Master_Barang;
use App\Models\Pgwr_Activity;
use App\Models\ActivityDetail;
use App\Models\Pegawai_Normal;
use App\Models\Master_Customer;
use App\Models\Pegawai_Rumahan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);

        \App\Models\Keuangan::create([
            'saldo_bank' =>0,
            'saldo_kas' =>0,
        ]);

        // create data master customer
        \App\Models\Master_Customer::create([
            'nama_customer' => 'PT. Maju Mundur',
            'alamat_customer' => 'Jl. Raya No. 1',
            'no_telp_customer' => '08123456789',
            'status_customer' => 'aktif',
        ]);

        // create data master customer
        \App\Models\Master_Customer::create([
            'nama_customer' => 'PT. Sedap Mulia',
            'alamat_customer' => 'Jl. Bukit No. 9',
            'no_telp_customer' => '081456231777',
            'status_customer' => 'aktif'
        ]);

        // make data master barang
        \App\Models\Master_Barang::create([
            'nama_barang' => 'Kaos Oblong',
            'harga_beli' => 100000,
            'harga_jual' => 150000,
        ]);
        \App\Models\Master_Barang::create([
            'nama_barang' => 'Celana Panjang',
            'harga_beli' => 150000,
            'harga_jual' => 200000,
        ]);

        // make data pegawai_rumahan
        \App\Models\Pegawai_Rumahan::create([
            'nama' => 'Budi',
            'nip' => '1234567890',
            'alamat' => 'Jl. Raya No. 1',
            'no_telp' => '08123456789',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'active',
            'gaji_bulanan' => 0, // 2jt
        ]);

        // make data pegawai_rumahan
        \App\Models\Pegawai_Rumahan::create([
            'nama' => 'Siti',
            'nip' => '1234567890',
            'alamat' => 'Jl. Raya No. 1',
            'no_telp' => '08123456789',
            'jenis_kelamin' => 'Perempuan',
            'status' => 'active',
            'gaji_bulanan' => 0, // 2jt
        ]);

        // make data pegawai_normal
        \App\Models\Pegawai_Normal::create([
            'nama' => 'Wibowo',
            'nip' => '1234567890',
            'alamat' => 'Jl. Raya No. 1',
            'no_telp' => '08123456789',
            'jenis_kelamin' => 'Laki-laki',
            'gaji_pokok' => 2000000, // 2jt
            'status' => 'active',
            'gaji_final' => 2000000, // 2jt
        ]);

        // make data pegawai_normal
        \App\Models\Pegawai_Normal::create([
            'nama' => 'Sitinurhaliza',
            'nip' => '1234567890',
            'alamat' => 'Jl. Raya No. 1',
            'no_telp' => '08123456789',
            'jenis_kelamin' => 'Perempuan',
            'gaji_pokok' => 2000000, // 2jt
            'status' => 'active',
            'gaji_final' => 2000000, // 2jt
        ]);

        // make data kasbon_pgw_tetap
        \App\Models\KasbonPgwTetap::create([
            'id_pgw_tetap' => 1,
            'tanggal' => '2022-02-18',
            'jumlah_kasbon' => 1000000, // 1jt
            'sisa' => 1000000, // 1jt
            'status' => 'Belum Lunas',
        ]);

        // make data kasbon_pgw_rumahan
        \App\Models\KasbonPgwRumahan::create([
            'id_pgw_rumahan' => 1,
            'tanggal' => '2022-02-18',
            'jumlah_kasbon' => 1000000, // 1jt
            'sisa' => 1000000, // 1jt
            'status' => 'Belum Lunas',
        ]);

        // include other seeders
        $this->call([
            master_pemasukan_seeder::class,
            master_pengeluaran_seeder::class,
            master_jaritan_seeder::class,
        ]);
    }
}
