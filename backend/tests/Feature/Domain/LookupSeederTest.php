<?php

namespace Tests\Feature\Domain;

use App\Models\LeagueRole;
use App\Models\LeagueStatus;
use App\Models\LeagueType;
use App\Models\PlayerRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LookupSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_lookup_seeders_create_expected_data_idempotently(): void
    {
        $this->seed();
        $this->seed();

        $this->assertSame(
            ['defender', 'forward', 'goalkeeper', 'midfielder'],
            PlayerRole::query()->orderBy('key')->pluck('key')->all(),
        );
        $this->assertSame(
            ['active', 'archived', 'completed', 'draft', 'setup'],
            LeagueStatus::query()->orderBy('key')->pluck('key')->all(),
        );
        $this->assertSame(
            ['classic', 'formula_one', 'head_to_head'],
            LeagueType::query()->orderBy('key')->pluck('key')->all(),
        );
        $this->assertSame(
            ['co_commissioner', 'commissioner', 'participant'],
            LeagueRole::query()->orderBy('key')->pluck('key')->all(),
        );

        $this->assertSame(4, PlayerRole::query()->count());
        $this->assertSame(5, LeagueStatus::query()->count());
        $this->assertSame(3, LeagueType::query()->count());
        $this->assertSame(3, LeagueRole::query()->count());
    }
}
