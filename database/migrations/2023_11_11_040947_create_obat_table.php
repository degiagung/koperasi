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
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->float('harga_jual');
            $table->float('harga_beli');
            $table->unsignedBigInteger('id_satuan'); 
            $table->bigInteger('stok');
            $table->foreign('id_satuan')
            ->references('id')
            ->on('satuan')
            ->onDelete('cascade'); //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
