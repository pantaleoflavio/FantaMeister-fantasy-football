<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('real_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matchday_id')->constrained()->cascadeOnDelete();
            $table->foreignId('home_club_id')->constrained('real_clubs')->restrictOnDelete();
            $table->foreignId('away_club_id')->constrained('real_clubs')->restrictOnDelete();
            $table->timestamp('kickoff_at');
            $table->unsignedSmallInteger('home_score')->nullable();
            $table->unsignedSmallInteger('away_score')->nullable();
            $table->string('status')->default('scheduled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('real_matches');
    }
};
