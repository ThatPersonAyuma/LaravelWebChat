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
        Schema::create('user_of_groups', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->reference('id')->on('users')->onDelete('cascade');
            // $table->unsignedBigInteger('group_id');
            // $table->foreign('group_id')->reference('id')->on('groups')->onDelete('cascade');
            $table->foreignId('users_of_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('groups_of_id')->constrained('groups')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_of_groups');
    }
};
