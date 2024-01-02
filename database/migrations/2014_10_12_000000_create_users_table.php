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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('no_anggota')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('nrp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('handphone')->nullable();
            $table->string('status')->nullable();
            $table->string('norek')->nullable();
            $table->string('pemilik_rekening')->nullable();
            $table->unsignedBigInteger('role_id'); 
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('role_id')
            ->references('id')
            ->on('users_roles')
            ->onDelete('cascade'); //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
