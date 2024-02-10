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
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mstr_pemasukan');
            $table->date('tanggal');
            $table->double('total');
            $table->text('keterangan')->nullable();
            $table->string('bukti_pembayaran')->nullable();

            // relationship
            $table->foreign('id_mstr_pemasukan')->references('id')->on('master_pemasukan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pemasukan');
    }
};
