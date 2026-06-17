<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formation_module_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_module_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_role_id')->constrained()->restrictOnDelete();
            $table->unsignedSmallInteger('required_count');
            $table->timestamps();
            $table->unique(['formation_module_id', 'player_role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation_module_requirements');
    }
};
