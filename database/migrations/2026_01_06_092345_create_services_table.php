<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();          // Photostat, Card Print etc
            $table->string('unit')->default('job');    // page, piece, job
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('status')->default(1);     // 1 active, 0 inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
