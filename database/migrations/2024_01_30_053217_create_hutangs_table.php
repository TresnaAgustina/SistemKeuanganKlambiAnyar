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
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengeluaran');
            $table->double('jumlah_hutang');
            $table->date('tgl_jatuh_tempo');
            $table->double('sisa_hutang');
            $table->enum('status', ['Lunas', 'Belum Lunas']);

            $table->foreign('id_pengeluaran')->references('id')->on('pengeluaran')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('hutang');
    }
};
