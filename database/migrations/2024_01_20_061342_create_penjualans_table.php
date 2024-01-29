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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mstr_jaritan');
            $table->date('tanggal');
            $table->string('nama_pembeli');
            $table->string('no_telp');
            $table->integer('quantity');
            $table->enum('metode_pembayaran', ['tunai', 'kredit']);
            $table->double('jmlh_bayar_awal')->nullable();
            $table->double('subtotal');
            $table->text('keterangan');
            $table->string('bukti_pembayaran')->nullable();
            // relationship
            $table->foreign('id_mstr_jaritan')->references('id')->on('master_jaritan')->onDelete('cascade');
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
        Schema::dropIfExists('penjualan');
    }
};
