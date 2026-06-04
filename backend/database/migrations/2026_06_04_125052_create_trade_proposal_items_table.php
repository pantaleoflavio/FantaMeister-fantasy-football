<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_proposal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_proposal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fantasy_team_id')->constrained('fantasy_teams')->restrictOnDelete();
            $table->foreignId('player_id')->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_proposal_items');
    }
};
