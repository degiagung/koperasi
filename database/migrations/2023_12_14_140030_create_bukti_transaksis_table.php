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
        Schema::create('bukti_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('tgl_awal')->nullable();
            $table->timestamp('tgl_akhir')->nullable();
            $table->string('file');
            $table->string('alamat');
            $table->string('size');
            $table->string('tipe');
            $table->string('jenis');
            $table->timestamps();

            $table->foreign('user_id')
               ->references('id')
               ->on('users')
               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_transaksi');
    }
};
