<?php

namespace Database\Factories;

use App\Models\FantasyTeam;
use App\Models\Formation;
use App\Models\FormationModule;
use App\Models\League;
use App\Models\Matchday;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Formation>
 */
class FormationFactory extends Factory
{
    protected $model = Formation::class;

    public function definition(): array
    {
        return [
            'league_id' => League::factory(),
            'fantasy_team_id' => FantasyTeam::factory(),
            'matchday_id' => Matchday::factory(),
            'formation_module_id' => FormationModule::query()->firstOrCreate(
                ['name' => '4-3-3'],
                ['label' => '4-3-3', 'is_active' => true],
            )->id,
            'is_confirmed' => false,
            'is_auto_generated' => false,
            'snapshot' => ['starters' => []],
        ];
    }
}
