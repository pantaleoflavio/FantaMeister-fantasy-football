<?php

namespace Database\Factories;

use App\Models\Formation;
use App\Models\FormationPlayer;
use App\Models\Player;
use App\Models\PlayerRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FormationPlayer>
 */
class FormationPlayerFactory extends Factory
{
    protected $model = FormationPlayer::class;

    public function definition(): array
    {
        return [
            'formation_id' => Formation::factory(),
            'player_id' => Player::factory(),
            'player_role_id' => PlayerRole::query()->firstOrCreate(
                ['key' => 'defender'],
                ['label' => 'Defender', 'sort_order' => 2],
            )->id,
            'slot_type' => 'starter',
            'position_index' => $this->faker->numberBetween(1, 11),
            'is_captain' => false,
        ];
    }
}
