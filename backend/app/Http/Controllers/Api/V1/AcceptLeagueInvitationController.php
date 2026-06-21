<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\League\LeagueMemberResource;
use App\Http\Resources\LeagueInvitation\LeagueInvitationPreviewResource;
use App\Models\LeagueInvitation;
use App\Services\LeagueInvitation\AcceptLeagueInvitationAction;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AcceptLeagueInvitationController extends Controller
{
     public function show(Request $request, string $code): LeagueInvitationPreviewResource
    {
        $invitation = $this->findAvailableInvitation($code)
            ->load(['league.season.realCompetition', 'league.type', 'league.status', 'league.memberships']);
        $invitation->league->loadCount('memberships');

        return new LeagueInvitationPreviewResource($invitation);
    }

    public function accept(Request $request, string $code, AcceptLeagueInvitationAction $action): LeagueMemberResource
    {
        $invitation = $this->findAvailableInvitation($code);

        return new LeagueMemberResource($action->handle($invitation, $request->user()));
    }

    private function findAvailableInvitation(string $code): LeagueInvitation
    {
        $invitation = LeagueInvitation::query()->where('code', $code)->first();

        if (! $invitation?->isAvailable()) {
            throw new NotFoundHttpException('Invitation is not available.');
        }

        return $invitation;
    }
}
