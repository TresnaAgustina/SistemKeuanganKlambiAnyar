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
        Schema::create('kasbon__pembelis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan');
            $table->double('jumlah_kasbon');
            $table->date('tgl_jatuh_tempo');
            $table->double('sisa');
            $table->enum('status', ['lunas', 'belum lunas']);

            // relationship
            $table->foreign('id_penjualan')->references('id')->on('penjualans')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('kasbon__pembelis');
    }
};
