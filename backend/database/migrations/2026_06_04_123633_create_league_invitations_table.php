<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('league_invitations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('league_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('created_by_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('code', 32);
            $table->string('status')->default('active');
            $table->unsignedInteger('max_uses')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->unique('code', 'league_invitations_code_unique');
            $table->index('expires_at', 'league_invitations_expires_at_index');
        });

        DB::statement(
            "ALTER TABLE league_invitations
             ADD CONSTRAINT league_invitations_status_check
             CHECK (status IN ('active', 'cancelled'))"
        );

        DB::statement(
            'ALTER TABLE league_invitations
             ADD CONSTRAINT league_invitations_used_count_non_negative_check
             CHECK (used_count >= 0)'
        );

        DB::statement(
            'ALTER TABLE league_invitations
             ADD CONSTRAINT league_invitations_max_uses_positive_check
             CHECK (max_uses IS NULL OR max_uses >= 1)'
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('league_invitations');
    }
};
