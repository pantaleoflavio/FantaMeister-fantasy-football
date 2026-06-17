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
            $table->string('name');
            $table->string('short_name', 32);
            $table->string('slug')->unique();
            $table->string('country_code', 2)->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('real_clubs');
    }
};
