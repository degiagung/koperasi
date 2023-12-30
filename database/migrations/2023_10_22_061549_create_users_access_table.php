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
        Schema::create('users_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_access_id');
            
            $table->unsignedBigInteger('user_id'); 
            
            $table->string('handphone', 20);
            $table->integer('i_create')->default(0);
            $table->integer('i_update')->default(0);
            $table->integer('i_delete')->default(0);
            $table->integer('i_view')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade'); //

            $table->foreign('menu_access_id')
                ->references('id')
                ->on('menus_access')
                ->onDelete('cascade'); // Mengatur foreign key ke tabel menus_access
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_access');
    }
};
