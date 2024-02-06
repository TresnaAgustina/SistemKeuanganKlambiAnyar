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
        Schema::create('cart_penjualan_jasa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan_jasa');
            $table->unsignedBigInteger('id_mstr_jaritan');
            $table->integer('jumlah_barang');
            $table->double('harga_satuan');
            $table->double('subtotal');

            $table->foreign('id_penjualan_jasa')->references('id')->on('penjualan_jasa_jarit')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_mstr_jaritan')->references('id')->on('master_jaritan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('cart_penjualan_jasa');
    }
};
