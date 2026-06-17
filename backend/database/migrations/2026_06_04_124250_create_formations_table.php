<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fantasy_team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('matchday_id')->constrained()->cascadeOnDelete();
            $table->foreignId('formation_module_id')->constrained()->restrictOnDelete();
            $table->foreignId('source_formation_id')->nullable()->constrained('formations')->nullOnDelete();
            $table->boolean('is_confirmed')->default(false);
            $table->boolean('is_auto_generated')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->jsonb('snapshot')->nullable();
            $table->timestamps();
            $table->unique(['fantasy_team_id', 'matchday_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
