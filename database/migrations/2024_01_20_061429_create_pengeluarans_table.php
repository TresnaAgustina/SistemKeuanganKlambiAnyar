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
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mstr_pengeluaran');
            $table->date('tanggal');
            $table->string('metode_pembayaran');
            $table->double('subtotal');
            $table->text('keterangan')->nullable();
            $table->string('bukti_pembayaran')->nullable();

            // relationship
            $table->foreign('id_mstr_pengeluaran')->references('id')->on('master_pengeluaran')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pengeluaran');
    }
};
