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
        Schema::table('kids', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_id'); // نفس نوع users.id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kids', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id']);
        });
    }
};
