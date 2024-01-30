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
        Schema::create('penjualan_jasa_jarit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mstr_jaritan');
            $table->unsignedBigInteger('id_keuangan');
            $table->string('kode_penjualan');
            $table->date('tanggal');
            $table->string('nama_pembeli');
            $table->string('no_telp');
            $table->integer('quantity');
            $table->enum('metode_pembayaran', ['cash', 'kredit']);
            $table->double('jmlh_bayar_awal')->nullable();
            $table->double('subtotal');
            $table->text('keterangan')->nullable();
            $table->string('bukti_pembayaran')->nullable();

            $table->foreign('id_mstr_jaritan')->references('id')->on('master_jaritan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_keuangan')->references('id')->on('keuangan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('penjualan_jasa_jarit');
    }
};
