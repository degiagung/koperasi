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
            $table->string('id_transaksi')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('nrp');
            $table->string('norek');
            $table->string('pemilik_rek');
            $table->decimal('amount', $precision = 18, $scale = 2)->default(0.00);
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
