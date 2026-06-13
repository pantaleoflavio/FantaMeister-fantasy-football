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
        Schema::create('player_season_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->foreignId('season_club_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_role_id')->constrained()->restrictOnDelete();
            $table->string('external_provider')->nullable();
            $table->string('external_id')->nullable();
            $table->unsignedSmallInteger('shirt_number')->nullable();
            $table->decimal('quotation', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
            $table->unique(['player_id', 'season_club_id']);
            $table->unique(['external_provider', 'external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_season_registrations');
    }
};
