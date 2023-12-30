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
        Schema::create('history_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('handphone')->nullable();
            $table->string('no_kamar')->nullable();
            $table->string('tipe')->nullable();
            $table->string('fasilitas')->nullable();
            $table->string('fasilitas_penghuni')->nullable();
            $table->timestamp('tgl_awal')->nullable();
            $table->timestamp('tgl_akhir')->nullable();
            $table->integer('jml_bulan')->default(0);
            $table->decimal('biaya_kamar', $precision = 18, $scale = 2)->default(0.00);
            $table->decimal('biaya_tambahan', $precision = 18, $scale = 2)->default(0.00);
            $table->decimal('total_biaya', $precision = 18, $scale = 2);
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
        Schema::dropIfExists('history_transaksi');
    }
};
