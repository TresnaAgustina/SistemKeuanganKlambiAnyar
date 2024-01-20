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
        Schema::create('kasbon__pegawais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pgw_normal')->nullable();
            $table->unsignedBigInteger('id_pgw_rumahan')->nullable();
            $table->date('tanggal');
            $table->double('jumlah_kasbon');
            $table->double('sisa');
            $table->enum('status', ['lunas', 'belum lunas']);

            // relationship
            $table->foreign('id_pgw_normal')->references('id')->on('pegawai__normals')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_pgw_rumahan')->references('id')->on('pegawai__rumahans')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('kasbon__pegawais');
    }
};
