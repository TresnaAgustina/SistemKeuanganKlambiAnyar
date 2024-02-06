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
        Schema::create('piutang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jual_lain')->nullable();
            $table->unsignedBigInteger('id_jual_jasa')->nullable();
            // jumlah_bayar = untuk update piutang ketika pelunasan
            $table->double('jumlah_bayar')->nullable();
            $table->double('jumlah_piutang');
            $table->date('tgl_jatuh_tempo');
            $table->double('sisa_piutang');
            $table->enum('status', ['Lunas', 'Belum Lunas']);

            $table->foreign('id_jual_lain')->references('id')->on('penjualan_lain')->onDelete('cascade');
            $table->foreign('id_jual_jasa')->references('id')->on('penjualan_jasa_jarit')->onDelete('cascade');
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
        Schema::dropIfExists('piutang');
    }
};
