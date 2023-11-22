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
        Schema::create('data_photo_kamar', function (Blueprint $table) {
            $table->id();
            $table->string('no_kamar');
            $table->string('file');
            $table->string('jenis');
            $table->string('size');
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_photo_kamar');
    }
};
