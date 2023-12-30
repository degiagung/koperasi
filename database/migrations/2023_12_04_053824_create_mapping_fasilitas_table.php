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
        Schema::create('mapping_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kamar');
            $table->unsignedBigInteger('id_fasilitas');
            $table->varchar('status')->default('aman');
            $table->timestamps();


            $table->foreign('id_kamar')
               ->references('id')
               ->on('kamar')
               ->onDelete('cascade'); //
    
           $table->foreign('id_fasilitas')
               ->references('id')
               ->on('fasilitas')
               ->onDelete('cascade');

        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapping_fasilitas');
    }
};
