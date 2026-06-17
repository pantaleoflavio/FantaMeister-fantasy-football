<?php

namespace Database\Factories;

use App\Models\Matchday;
use App\Models\RealMatch;
use App\Models\SeasonClub;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RealMatch>
 */
class RealMatchFactory extends Factory
{
    protected $model = RealMatch::class;

    public function definition(): array
    {
        $matchday = Matchday::factory()->create();

        return [
            'matchday_id' => $matchday->id,
            'home_season_club_id' => SeasonClub::factory()->create(['season_id' => $matchday->season_id])->id,
            'away_season_club_id' => SeasonClub::factory()->create(['season_id' => $matchday->season_id])->id,
            'kickoff_at' => $matchday->starts_at->copy()->addHours(2),
            'home_score' => null,
            'away_score' => null,
            'status' => 'scheduled',
        ];
    }
}
