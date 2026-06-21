<?php

namespace App\Services\LeagueInvitation;

use App\Models\League;
use App\Models\LeagueInvitation;
use App\Models\LeagueMembership;
use App\Models\LeagueRole;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AcceptLeagueInvitationAction
{
    public function handle(LeagueInvitation $invitation, User $user): LeagueMembership
    {
        try {
            return DB::transaction(function () use ($invitation, $user): LeagueMembership {
                $locked = LeagueInvitation::query()->whereKey($invitation->id)->lockForUpdate()->firstOrFail();

                if (! $locked->isAvailable()) {
                    throw new NotFoundHttpException('Invitation is not available.');
                }

                $league = League::query()->whereKey($locked->league_id)->lockForUpdate()->firstOrFail();

                if ($league->memberships()->where('user_id', $user->id)->exists()) {
                    throw new ConflictHttpException('User is already a member of this league.');
                }

                if ($league->memberships()->count() >= $league->max_participants) {
                    throw new ConflictHttpException('League is full.');
                }

                $participantRole = LeagueRole::query()->where('key', 'participant')->firstOrFail();

                $membership = LeagueMembership::query()->create([
                    'league_id' => $league->id,
                    'user_id' => $user->id,
                    'league_role_id' => $participantRole->id,
                    'joined_at' => now(),
                ]);

                $locked->forceFill(['used_count' => $locked->used_count + 1])->save();

                return $membership->load(['league.season.realCompetition', 'league.type', 'league.status', 'role', 'user']);
            });
        } catch (UniqueConstraintViolationException $exception) {
            throw new ConflictHttpException('User is already a member of this league.', $exception);
        }
    }
}