<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasbon_pgw_tetap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pgw_tetap')->constrained('pegawai_normal');
            $table->date('tanggal');
            $table->bigInteger('jumlah_kasbon');
            $table->bigInteger('sisa');
            $table->enum('status', ['lunas', 'belum lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kasbon_pgw_tetap');
    }
};
