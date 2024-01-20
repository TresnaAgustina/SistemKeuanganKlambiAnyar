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
        Schema::create('bayaran__pegawai__rumahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pgw_rumahan');
            $table->unsignedBigInteger('id_kasbon_pgw')->nullable();
            $table->unsignedBigInteger('id_mstr_jaritan')->nullable();
            $table->date('tanggal');
            $table->integer('banyak_jarit');
            $table->double('jumlah');
            $table->double('jumlah_bersih');

            // relationship
            $table->foreign('id_pgw_rumahan')->references('id')->on('pegawai__rumahans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_kasbon_pgw')->references('id')->on('kasbon__pegawais')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_mstr_jaritan')->references('id')->on('master__jaritans')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('bayaran__pegawai__rumahans');
    }
};
