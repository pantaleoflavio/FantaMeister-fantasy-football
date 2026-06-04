<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_player_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_role_id')->constrained()->restrictOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->unique(['player_id', 'player_role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_player_role');
    }
};
