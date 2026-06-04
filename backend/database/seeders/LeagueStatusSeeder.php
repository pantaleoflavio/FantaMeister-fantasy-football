<?php

namespace Database\Seeders;

use App\Models\LeagueStatus;
use Illuminate\Database\Seeder;

class LeagueStatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach (
            [
                ['draft', 'Draft', 1],
                ['setup', 'Setup', 2],
                ['active', 'Active', 3],
                ['completed', 'Completed', 4],
                ['archived', 'Archived', 5],
            ] as [$key, $label, $sort]
        ) {
            LeagueStatus::query()->updateOrCreate(
                ['key' => $key],
                ['label' => $label, 'sort_order' => $sort],
            );
        }
    }
}
