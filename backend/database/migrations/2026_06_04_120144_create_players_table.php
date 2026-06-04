<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('real_club_id')->constrained('real_clubs')->restrictOnDelete();
            $table->string('external_id')->nullable()->index();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('display_name');
            $table->string('slug');
            $table->date('birth_date')->nullable();
            $table->decimal('quotation', 8, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['real_club_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
