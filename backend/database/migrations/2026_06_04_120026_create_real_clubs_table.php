<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('real_clubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('short_name', 32);
            $table->string('slug');
            $table->string('logo_path')->nullable();
            $table->timestamps();
            $table->unique(['season_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('real_clubs');
    }
};
