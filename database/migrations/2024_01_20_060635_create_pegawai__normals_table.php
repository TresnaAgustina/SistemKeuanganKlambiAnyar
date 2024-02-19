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
        Schema::create('pegawai_normal', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip');
            $table->string('alamat');
            $table->string('no_telp');
            $table->enum('jenis_kelamin', ['Perempuan' ,'Laki-laki']);
            $table->double('gaji_pokok');
            $table->enum('status', ['active', 'inactive']);
            $table->double('gaji_final')->nullable();
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
        Schema::dropIfExists('pegawai_normal');
    }
};
