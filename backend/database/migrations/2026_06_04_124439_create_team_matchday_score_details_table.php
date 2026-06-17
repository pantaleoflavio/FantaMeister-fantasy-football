<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_matchday_score_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_matchday_score_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_id')->constrained()->restrictOnDelete();
            $table->foreignId('player_score_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('replaced_player_id')->nullable()->constrained('players')->nullOnDelete();
            $table->decimal('points', 8, 2)->default(0);
            $table->boolean('was_starter')->default(false);
            $table->boolean('was_bench')->default(false);
            $table->boolean('was_used_as_substitute')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_matchday_score_details');
    }
};
