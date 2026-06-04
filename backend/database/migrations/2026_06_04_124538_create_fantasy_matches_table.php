<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fantasy_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->cascadeOnDelete();
            $table->foreignId('matchday_id')->constrained()->cascadeOnDelete();
            $table->foreignId('home_fantasy_team_id')->constrained('fantasy_teams')->restrictOnDelete();
            $table->foreignId('away_fantasy_team_id')->constrained('fantasy_teams')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fantasy_matches');
    }
};
