<?php

namespace Database\Seeders;

use App\Models\LeagueType;
use Illuminate\Database\Seeder;

class LeagueTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (
            [
                ['classic', 'Classic', 'Standings based on total fantasy points'],
                ['formula_one', 'Formula One', 'Points assigned by matchday placement'],
                ['head_to_head', 'Head to Head', 'Direct matches with fantasy points converted into goals'],
            ] as [$key, $label, $description]
        ) {
            LeagueType::query()->updateOrCreate(['key' => $key], compact('label', 'description'));
        }
    }
}
