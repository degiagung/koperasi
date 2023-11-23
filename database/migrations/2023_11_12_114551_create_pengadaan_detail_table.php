<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengadaan_detail', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_pengadaan'); 
            $table->unsignedBigInteger('id_obat'); 
            $table->bigInteger('qty_request');
            $table->bigInteger('qty_terima'); 
            

            $table->foreign('id_pengadaan')
            ->references('id')
            ->on('pengadaan')
            ->onDelete('cascade'); //

            $table->foreign('id_obat')
            ->references('id')
            ->on('obat')
            ->onDelete('cascade'); //

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_detail');
    }
};
