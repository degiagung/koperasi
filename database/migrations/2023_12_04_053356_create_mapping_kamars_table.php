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
        Schema::create('mapping_kamar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('id_kamar');
            $table->unsignedBigInteger('id_tipe');
            $table->timestamp('tgl_awal')->nullable();
            $table->timestamp('tgl_akhir')->nullable();
            $table->timestamps();
            
            
            $table->foreign('user_id')
               ->references('id')
               ->on('users')
               ->onDelete('cascade'); //
    
           $table->foreign('id_kamar')
               ->references('id')
               ->on('kamar')
               ->onDelete('cascade');

            $table->foreign('id_tipe')
               ->references('id')
               ->on('tipe_kamar')
               ->onDelete('cascade');
               
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapping_kamar');
    }
};
