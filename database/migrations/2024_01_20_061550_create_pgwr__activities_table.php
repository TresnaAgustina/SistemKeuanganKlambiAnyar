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
        Schema::create('pgwr_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pgw_rumahan');
            $table->double('gaji_bulanan');

            $table->foreign('id_pgw_rumahan')->references('id')->on('pegawai_rumahan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pgwr_activities');
    }
};
