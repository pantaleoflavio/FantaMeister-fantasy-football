<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fantasy_match_results', function (Blueprint $table) {
            $table->id();
                        $table->foreignId('fantasy_match_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('home_points', 8, 2)->default(0);
            $table->decimal('away_points', 8, 2)->default(0);
            $table->unsignedSmallInteger('home_goals')->default(0);
            $table->unsignedSmallInteger('away_goals')->default(0);
            $table->string('result_status')->default('pending');
            $table->timestamp('calculated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fantasy_match_results');
    }
};
