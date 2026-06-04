<?php

namespace Tests\Feature\Domain;

use App\Models\FantasyTeam;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FantasyTeamConstraintTest extends TestCase
{
    use RefreshDatabase;

    public function test_fantasy_team_is_unique_per_league_and_user(): void
    {
        $team = FantasyTeam::factory()->create();

        $this->expectException(QueryException::class);

        FantasyTeam::factory()->create([
            'league_id' => $team->league_id,
            'user_id' => $team->user_id,
        ]);
    }
}
