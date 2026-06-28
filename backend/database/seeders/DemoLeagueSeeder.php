<?php

namespace Database\Seeders;

use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\LeagueRole;
use App\Models\LeagueStatus;
use App\Models\LeagueType;
use App\Models\RealCompetition;
use App\Models\Season;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoLeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competition = RealCompetition::query()->where('code', 'serie_a')->firstOrFail();
        $season = Season::query()->firstOrCreate(
            [
            'real_competition_id' => $competition->id,
            'name' => '2025/2026',
            ],
            [
                'starts_at' => now()->startOfYear(),
                'ends_at' => now()->endOfYear(),
                'is_active' => true,
            ]
        );

        $commissioner = User::factory()->create([
            'name' => 'Demo Commissioner',
            'email' => 'demo.commissioner@example.com',
            'password' => bcrypt('password'),
        ]);

        $league = League::create([
            'season_id' => $season->id,
            'league_type_id' => LeagueType::query()->where('key', 'classic')->firstOrFail()->id,
            'league_status_id' => LeagueStatus::query()->where('key', 'draft')->firstOrFail()->id,
            'commissioner_user_id' => $commissioner->id,
            'name' => 'Demo League',
            'slug' => 'demo-league',
            'description' => 'Demo league for local development.',
            'max_participants' => 10,
        ]);

        $commissionerRole = LeagueRole::query()->where('key', 'commissioner')->firstOrFail();
        $participantRole = LeagueRole::query()->where('key', 'participant')->firstOrFail();

        $this->attachMember($league, $commissioner, $commissionerRole->id);

        FantasyTeam::factory()
            ->forLeagueAndUser($league, $commissioner)
            ->create([
                'name' => 'Commissioner FC',
                'slug' => 'commissioner-fc',
            ]);

        User::factory()
            ->count(7)
            ->create()
            ->each(function (User $user) use ($league, $participantRole) {
                $this->attachMember($league, $user, $participantRole->id);

                $name = "{$user->name} FC";

                FantasyTeam::factory()
                    ->forLeagueAndUser($league, $user)
                    ->create([
                        'name' => $name,
                        'slug' => Str::slug($name),
                    ]);
            });
    }

    private function attachMember(League $league, User $user, int $leagueRoleId): void
    {
        $league->users()->syncWithoutDetaching([
            $user->id => [
                'league_role_id' => $leagueRoleId,
                'joined_at' => now(),
            ],
        ]);
    }
}
