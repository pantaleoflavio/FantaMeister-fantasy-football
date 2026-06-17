<?php

namespace Database\Seeders;

use App\Models\RealCompetition;
use Illuminate\Database\Seeder;

class RealCompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competitions = [
            ['name' => 'Serie A', 'code' => 'serie_a', 'country_code' => 'IT', 'type' => 'domestic_league'],
            ['name' => 'Bundesliga', 'code' => 'bundesliga', 'country_code' => 'DE', 'type' => 'domestic_league'],
            ['name' => 'Premier League', 'code' => 'premier_league', 'country_code' => 'GB', 'type' => 'domestic_league'],
            ['name' => 'La Liga', 'code' => 'la_liga', 'country_code' => 'ES', 'type' => 'domestic_league'],
            ['name' => 'Ligue 1', 'code' => 'ligue_1', 'country_code' => 'FR', 'type' => 'domestic_league'],
            ['name' => 'Champions League', 'code' => 'champions_league', 'country_code' => null, 'type' => 'international_club'],
            ['name' => 'Custom Euroleague', 'code' => 'custom_euroleague', 'country_code' => null, 'type' => 'custom'],
        ];

        foreach ($competitions as $competition) {
            RealCompetition::query()->updateOrCreate(
                ['code' => $competition['code']],
                [...$competition, 'is_active' => true],
            );
        }
    }
}
