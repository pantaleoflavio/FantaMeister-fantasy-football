<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('league_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->cascadeOnDelete();
            $table->string('key');
            $table->jsonb('value');
            $table->timestamps();
            $table->unique(['league_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('league_settings');
    }
};
