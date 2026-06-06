<?php

namespace Tests\Feature\Domain;

use App\Models\FantasyMatch;
use App\Models\FantasyMatchResult;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FantasyMatchResultConstraintTest extends TestCase
{
    use RefreshDatabase;

    public function test_fantasy_match_can_have_only_one_result(): void
    {
        $fantasyMatch = FantasyMatch::factory()->create();

        FantasyMatchResult::factory()->create([
            'fantasy_match_id' => $fantasyMatch->id,
        ]);

        $this->expectException(QueryException::class);

        FantasyMatchResult::factory()->create([
            'fantasy_match_id' => $fantasyMatch->id,
        ]);
    }
}
