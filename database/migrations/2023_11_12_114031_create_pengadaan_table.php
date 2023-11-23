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
        Schema::create('pengadaan', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengadaan')->unique();
            $table->unsignedBigInteger('request_user_id');
            $table->bigInteger('approve_user_id');
            $table->bigInteger('accept_user_id');
            $table->bigInteger('accept_user_id');
            $table->unsignedBigInteger('id_supplier'); 
            $table->tinyInteger('status'); 
            $table->float('total_harga');

            $table->foreign('request_user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade'); //
            

            $table->foreign('id_supplier')
            ->references('id')
            ->on('supplier')
            ->onDelete('cascade'); //

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan');
    }
};
