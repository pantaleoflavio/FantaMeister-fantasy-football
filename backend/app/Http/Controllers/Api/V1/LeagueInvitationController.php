<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\LeagueInvitationCapacityExceeded;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeagueInvitation\StoreLeagueInvitationRequest;
use App\Http\Resources\LeagueInvitation\LeagueInvitationResource;
use App\Models\League;
use App\Models\LeagueInvitation;
use App\Services\LeagueInvitation\CancelLeagueInvitationAction;
use App\Services\LeagueInvitation\CreateLeagueInvitationAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class LeagueInvitationController extends Controller
{
    public function index(League $league): AnonymousResourceCollection
    {
        Gate::authorize('manageInvitations', $league);

        return LeagueInvitationResource::collection(
            $league->invitations()->with('createdBy')->latest()->paginate()
        );
    }

    public function store(StoreLeagueInvitationRequest $request, League $league, CreateLeagueInvitationAction $action): JsonResponse
    {
        Gate::authorize('manageInvitations', $league);

        try {
            $invitation = $action->handle($league, $request->user(), $request->validated())->load('createdBy');
        } catch (LeagueInvitationCapacityExceeded $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'errors' => ['max_uses' => [$exception->getMessage()]],
            ], 422);
        }

        return (new LeagueInvitationResource($invitation))->response()->setStatusCode(201);
    }

    public function destroy(League $league, LeagueInvitation $invitation, CancelLeagueInvitationAction $action): JsonResponse
    {
        abort_unless($invitation->league_id === $league->id, 404);
        Gate::authorize('manageInvitations', $league);

        $action->handle($invitation);

        return response()->json(null, 204);
    }
}
