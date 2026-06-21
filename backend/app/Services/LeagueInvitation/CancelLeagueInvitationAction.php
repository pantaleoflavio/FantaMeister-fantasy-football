<?php

namespace App\Services\LeagueInvitation;

use App\Enums\LeagueInvitationStatus;
use App\Models\LeagueInvitation;

class CancelLeagueInvitationAction
{
    public function handle(LeagueInvitation $invitation): void
    {
        $invitation->forceFill(['status' => LeagueInvitationStatus::Cancelled])->save();
    }
}