<?php

namespace App\Policies;

use App\Models\League;
use App\Models\LeagueRole;
use App\Models\User;

class LeaguePolicy
{
    public function view(User $user, League $league): bool
    {
        return $league->users()->whereKey($user->id)->exists();
    }

    public function update(User $user, League $league): bool
    {
        return $this->hasRole($user, $league, 'commissioner');
    }

    public function delete(User $user, League $league): bool
    {
        return $this->hasRole($user, $league, 'commissioner');
    }

    private function hasRole(User $user, League $league, string $role): bool
    {
        return $league->users()
            ->whereKey($user->id)
            ->wherePivot(
                'league_role_id',
                LeagueRole::query()->where('key', $role)->value('id')
            )
            ->exists();
    }
}
