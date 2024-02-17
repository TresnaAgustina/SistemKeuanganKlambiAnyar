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
        Schema::create('activity_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_activity_detail');
            $table->unsignedBigInteger('id_mstr_jaritan');
            $table->integer('jumlah_jaritan');
            $table->double('total_bayaran');

            $table->foreign('id_activity_detail')->references('id')->on('activity_details')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('activity_items');
    }
};
