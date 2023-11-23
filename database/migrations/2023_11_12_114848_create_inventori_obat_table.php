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
        Schema::create('inventori_obat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_obat'); 
            $table->string('kode_pengadaan'); 
            $table->string('kode_penjualan'); 

            $table->bigInteger('qty_in');
            $table->bigInteger('qty_out'); 

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
        Schema::dropIfExists('inventori_obat');
    }
};
