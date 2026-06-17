<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_matchday_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fantasy_team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('matchday_id')->constrained()->cascadeOnDelete();
            $table->foreignId('formation_id')->constrained()->restrictOnDelete();
            $table->decimal('points', 8, 2)->default(0);
            $table->decimal('base_points', 8, 2)->default(0);
            $table->decimal('substitution_points', 8, 2)->default(0);
            $table->decimal('defense_modifier_points', 8, 2)->default(0);
            $table->decimal('goalkeeper_clean_sheet_bonus_points', 8, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamp('calculated_at')->nullable();
            $table->timestamps();
            $table->unique(['fantasy_team_id', 'matchday_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_matchday_scores');
    }
};
