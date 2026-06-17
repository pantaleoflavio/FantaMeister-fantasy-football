<?php

namespace Database\Seeders;

use App\Models\LeagueRole;
use Illuminate\Database\Seeder;

class LeagueRoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (
            [
                ['commissioner', 'Commissioner'],
                ['co_commissioner', 'Co-Commissioner'],
                ['participant', 'Participant'],
            ] as [$key, $label]
        ) {
            LeagueRole::query()->updateOrCreate(['key' => $key], ['label' => $label]);
        }
    }
}
