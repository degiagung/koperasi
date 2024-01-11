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
        Schema::create('simpanan_sukarela', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->nullable();
            $table->decimal('amount', $precision = 18, $scale = 2)->default(0.00);
            $table->date('tgl_awal')->default(null);
            $table->string('durasi')->default(null);
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
        Schema::dropIfExists('simpanan_sukarela');
    }
};
