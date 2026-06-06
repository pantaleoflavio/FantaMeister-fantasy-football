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
        Schema::create('season_clubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->foreignId('real_club_id')->constrained()->restrictOnDelete();
            $table->string('display_name')->nullable();
            $table->string('external_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['season_id', 'real_club_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('season_clubs');
    }
};
