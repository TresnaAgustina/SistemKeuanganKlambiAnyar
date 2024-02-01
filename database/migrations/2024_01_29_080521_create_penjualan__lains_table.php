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
        Schema::create('penjualan_lain', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mstr_barang');
            $table->unsignedBigInteger('id_keuangan');
            $table->unsignedBigInteger('id_customer');
            $table->string('kode_penjualan');
            $table->date('tanggal');
            $table->integer('quantity');
            $table->double('subtotal');
            $table->enum('metode_pembayaran', ['cash', 'kredit']);
            $table->double('jmlh_bayar_awal')->nullable();
            $table->date('tgl_jatuh_tempo')->nullable();
            $table->double('total_harga');
            $table->text('keterangan')->nullable();
            $table->string('bukti_pembayaran')->nullable();

            $table->foreign('id_mstr_barang')->references('id')->on('master_barang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_keuangan')->references('id')->on('keuangan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_customer')->references('id')->on('master_customer')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('penjualan_lain');
    }
};