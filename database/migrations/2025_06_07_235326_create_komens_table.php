<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('komens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->OnDelete('cascade');
            $table->foreignId('film_id')->constrained()->onDelete('cascade');
            $table->text('komen');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komens');
    }
};
