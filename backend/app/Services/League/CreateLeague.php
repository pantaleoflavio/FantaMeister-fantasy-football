<?php

namespace App\Services\League;

use App\Models\League;
use App\Models\LeagueRole;
use App\Models\LeagueStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateLeague
{
    public function handle(array $data, User $user): League
    {
        return DB::transaction(function () use ($data, $user): League {
            $status = LeagueStatus::where('key', 'draft')->firstOrFail();
            $role = LeagueRole::where('key', 'commissioner')->firstOrFail();

            $league = League::create([
                ...$data,
                'league_status_id' => $status->id,
                'commissioner_user_id' => $user->id,
                'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(6)),
            ]);

            $league->users()->attach($user->id, [
                'league_role_id' => $role->id,
                'joined_at' => now(),
            ]);

            return $league;
        });
    }
}
