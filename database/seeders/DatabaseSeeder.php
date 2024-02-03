<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // include other seeders
        $this->call([
            master_pemasukan_seeder::class,
            master_pengeluaran_seeder::class,
            master_jaritan_seeder::class,
        ]);
    }
}
