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
        Schema::create('cart_penjualan_lain', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan_lain');
            $table->unsignedBigInteger('id_mstr_barang');
            $table->integer('jumlah_barang');
            $table->double('harga_satuan');
            $table->double('subtotal');

            $table->foreign('id_penjualan_lain')->references('id')->on('penjualan_lain')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_mstr_barang')->references('id')->on('master_barang')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('cart_penjualan_lain');
    }
};
