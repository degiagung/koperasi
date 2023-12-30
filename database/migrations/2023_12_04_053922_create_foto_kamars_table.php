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
        Schema::create('foto_kamar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kamar');
            $table->string('file');
            $table->string('alamat');
            $table->string('size');
            $table->string('tipe');
            $table->string('jenis');
            $table->timestamps();

            $table->foreign('id_kamar')
               ->references('id')
               ->on('kamar')
               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_kamar');
    }
};
