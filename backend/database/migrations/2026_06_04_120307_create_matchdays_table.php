<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matchdays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('number');
            $table->string('name');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->string('status')->default('scheduled');
            $table->timestamps();
            $table->unique(['season_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matchdays');
    }
};
